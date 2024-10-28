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

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Exceptions\Thrower;

class FreeEmailVerificationController extends EmailVerificationController
{
    public function getAuthManager(): AuthManager
    {
        return Resolver::authManager();
    }

    #[\Override]
    public function getContext(): iterable
    {
        yield from parent::getContext();

        yield from $this->getCredentialsContext();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getCredentialsContext(): iterable
    {
        yield 'credentials' => [
            'email' => $this->getEmail(),
        ];
    }

    public function getThrower(): Thrower
    {
        return Thrower::inject(['validator' => $this->createValidator([])]);
    }

    /**
     * @return iterable<array-key, array<array-key, mixed>>
     */
    public function getUniqueCredentials(): iterable
    {
        yield [
            'email' => $this->getEmail(),
        ];
    }

    public function getUserProvider(): UserProvider
    {
        return $this->getAuthManager()->createUserProvider() ?? throw new \RuntimeException('Unable to create user provider.');
    }

    #[\Override]
    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->uniqueCredentials();

        return parent::handle();
    }

    public function uniqueCredentials(): void
    {
        $uniqueCredentials = $this->getUniqueCredentials();
        $userProvider = $this->getUserProvider();

        foreach ($uniqueCredentials as $credentials) {
            if ($credentials === []) {
                continue;
            }

            $found = $userProvider->retrieveByCredentials($credentials);

            if ($found instanceof Authenticatable) {
                $this->getThrower()->failures(\array_keys($credentials), 'Unique')->throw(409);
            }
        }
    }
}
