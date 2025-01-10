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
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Exceptions\Thrower;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class OccupiedEmailVerificationController extends EmailVerificationController
{
    public function authorize(): void
    {
        $ability = $this->getAuthorizeAbility();

        if ($ability === true) {
            return;
        }

        if ($ability === false) {
            throw new AuthorizationException();
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        $gate->authorize($ability, $this->retrieveAuthenticatable());
    }

    public function authorizePassword(): void
    {
        if (!$this->getHasher()->check($this->getPassword(), $this->retrieveAuthenticatable()->getAuthPassword())) {
            $this->getThrower()->errors(['password'], $this->getTrans()->string('auth.password'))->throw(403);
        }
    }

    public function getAuthManager(): AuthManager
    {
        return Resolver::authManager();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getAuthenticatableContext(): iterable
    {
        $authenticatable = $this->retrieveAuthenticatable();

        yield 'authenticatable' => [
            'id' => $authenticatable->getAuthIdentifier(),
            'class' => $authenticatable::class,
            'password' => $authenticatable->getAuthPassword(),
        ];
    }

    public function getAuthorizeAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['authorize_ability'] ?? true;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    #[\Override]
    public function getContext(): iterable
    {
        yield from parent::getContext();

        yield from $this->getAuthenticatableContext();
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

    /**
     * @return iterable<array-key, array<array-key, mixed>>
     */
    public function getRetrieveCredentials(): iterable
    {
        yield [
            'email' => $this->getEmail(),
        ];
    }

    public function getThrower(): Thrower
    {
        return Thrower::inject(['validator' => $this->createValidator([])]);
    }

    public function getTrans(): Trans
    {
        return Trans::inject();
    }

    public function getUserProvider(): UserProvider
    {
        return $this->getAuthManager()->createUserProvider() ?? throw new \RuntimeException('Unable to create user provider.');
    }

    #[\Override]
    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authenticate();
        $this->authorize();

        if ($this->shouldAuthorizePassword()) {
            $this->authorizePassword();
        }

        $this->notify();

        return $this->getResponse();
    }

    public function retrieveAuthenticatable(): Authenticatable
    {
        return \once(function (): Authenticatable {
            $retrieveCredentials = \iterator_to_array($this->getRetrieveCredentials());
            $userProvider = $this->getUserProvider();

            foreach ($retrieveCredentials as $credentials) {
                if ($credentials === []) {
                    continue;
                }

                $found = $userProvider->retrieveByCredentials($credentials);

                if ($found instanceof Authenticatable) {
                    return $found;
                }
            }

            $this->getThrower()->errors(\array_keys(\array_reduce($retrieveCredentials, 'array_merge', [])), $this->getTrans()->string('auth.failed'))->throw(404);
        });
    }

    public function shouldAuthorizePassword(): bool
    {
        $ability = $this->getPasswordAbility();

        if (\is_bool($ability)) {
            return !$ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->allows($ability, $this->retrieveAuthenticatable());
    }
}
