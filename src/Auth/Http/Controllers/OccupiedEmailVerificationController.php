<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2024–Present Tomáš Chochola <chocholatom1997@gmail.com>. All rights reserved.
 *
 * @license
 *
 * This software is proprietary and licensed under specific terms set by its owner.
 * Any form of access, use, or distribution requires a valid and active license.
 * For full licensing terms, refer to the LICENSE.md file accompanying this software.
 *
 * @see {@link https://premierstacks.com} Website
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Auth\Http\Controllers;

use Illuminate\Auth\Access\Gate;
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
use Premierstacks\PhpStack\Mixed\Filter;

class OccupiedEmailVerificationController extends EmailVerificationController
{
    public function authorize(): void
    {
        $gate = $this->getGate()->forUser($this->retrieveAuthenticatable());
        $scope = $this->getScope();

        if ($gate->has($scope)) {
            $gate->authorize($scope);
        }
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

    #[\Override]
    public function getContext(): iterable
    {
        yield from parent::getContext();

        yield from $this->getAuthenticatableContext();
    }

    public function getGate(): Gate
    {
        return Resolver::gate();
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
        $this->authorize();

        if ($this->shouldAuthorizePassword()) {
            $this->authorizePassword();
        }

        return parent::handle();
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
        $gate = $this->getGate()->forUser($this->retrieveAuthenticatable());
        $scope = $this->getScope();

        if ($gate->has("{$scope}_password_authorization")) {
            return $gate->allows("{$scope}_password_authorization");
        }

        if ($gate->has('password_authorization')) {
            return $gate->allows('password_authorization');
        }

        return true;
    }
}
