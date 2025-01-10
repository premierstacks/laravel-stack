<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025, Tomáš Chochola <chocholatom1997@gmail.com>. Some rights reserved.
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Auth\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Exceptions\Thrower;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class MineEmailVerificationController extends EmailVerificationController
{
    public function authorizePassword(): void
    {
        if (!$this->getHasher()->check($this->getPassword(), $this->getAuthenticatable()->getAuthPassword())) {
            $this->getThrower()->errors(['password'], $this->getTrans()->string('auth.password'))->throw(403);
        }
    }

    #[\Override]
    public function getAuthenticatable(): Authenticatable
    {
        return \once(static fn(): Authenticatable => Resolver::authenticatableContract() ?? throw new AuthenticationException(guards: [null]));
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getAuthenticatableContext(): iterable
    {
        $authenticatable = $this->getAuthenticatable();

        yield 'authenticatable' => [
            'id' => $authenticatable->getAuthIdentifier(),
            'class' => $authenticatable::class,
            'password' => $authenticatable->getAuthPassword(),
        ];
    }

    #[\Override]
    public function getContext(): iterable
    {
        yield from parent::getContext();

        yield from $this->getAuthenticatableContext();
    }

    #[\Override]
    public function getEmail(): string
    {
        $authenticatable = $this->getAuthenticatable();

        if ($authenticatable instanceof Model && $authenticatable->hasAttribute('email')) {
            $email = $authenticatable->getAttribute('email');

            if (\is_string($email) && $email !== '') {
                return $email;
            }
        }

        if ($authenticatable instanceof CanResetPassword) {
            $email = $authenticatable->getEmailForPasswordReset();

            if (\is_string($email) && $email !== '') {
                return $email;
            }
        }

        if ($authenticatable instanceof MustVerifyEmail) {
            $email = $authenticatable->getEmailForVerification();

            if (\is_string($email) && $email !== '') {
                return $email;
            }
        }

        throw new AuthorizationException(previous: new \LogicException('Unable to retrieve email from authenticatable'));
    }

    public function getHasher(): Hasher
    {
        return Resolver::hasherContract();
    }

    public function getPassword(): string
    {
        return Filter::string($this->createValidator([
            'password' => $this->getAuthenticatableValidity()->password()->required()->compile(),
        ])->validate()['password'] ?? null);
    }

    public function getPasswordAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['password_ability'] ?? false;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    public function getThrower(): Thrower
    {
        return Thrower::inject(['validator' => $this->createValidator([])]);
    }

    public function getTrans(): Trans
    {
        return Trans::inject();
    }

    #[\Override]
    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authenticate();

        if ($this->shouldAuthorizePassword()) {
            $this->authorizePassword();
        }

        $this->notify();

        return $this->getResponse();
    }

    public function shouldAuthorizePassword(): bool
    {
        $ability = $this->getPasswordAbility();

        if (\is_bool($ability)) {
            return !$ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->denies($ability);
    }
}
