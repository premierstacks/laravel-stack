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

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Auth\Guards\UnlimitedTokenGuard;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\AuthJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\Validation\AuthenticatableValidity;
use Premierstacks\LaravelStack\Auth\Http\Validation\VerificationValidity;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Exceptions\Thrower;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\LaravelStack\Verification\Verificator;
use Premierstacks\LaravelStack\Verification\VerificatorInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class RegisterController
{
    public function authenticate(): void
    {
        $authenticatable = $this->getAuthenticatable();

        $ability = $this->getAuthenticateAbility();

        if ($ability === true) {
            return;
        }

        if ($ability === false) {
            throw new AuthorizationException();
        }

        $gate = $this->getGate()->forUser($authenticatable);

        $gate->authorize($ability);
    }

    public function authorizeCredentials(): void
    {
        $credentalsToAuthorize = \iterator_to_array($this->getCredentialsToAuthorize());

        $verificator = $this->getVerificator();

        foreach ($credentalsToAuthorize as $credentials) {
            if ($credentials === []) {
                continue;
            }

            if ($verificator->retrieveActive($this->getSessionId(), $this->createCredentialsAuthorizationContext($credentials)) === null) {
                $this->getThrower()->failures(\array_keys($credentials), 'Confirmed')->throw(403);
            }
        }

        foreach ($credentalsToAuthorize as $credentials) {
            if ($credentials === []) {
                continue;
            }

            $verification = $verificator->retrieveActive($this->getSessionId(), $this->createCredentialsAuthorizationContext($credentials));

            if ($verification === null) {
                $this->getThrower()->failures(\array_keys($credentials), 'Confirmed')->throw(403);
            }

            if (!$verificator->decrementUses($verification)) {
                $this->getThrower()->failures(\array_keys($credentials), 'Confirmed')->throw(403);
            }
        }
    }

    public function createAuthenticatable(): Authenticatable
    {
        return \once(function (): Authenticatable {
            $authenticatable = $this->getEloquentUserProvider()->createModel();

            if (!$authenticatable instanceof Authenticatable) {
                throw new \LogicException('Model is not authenticatable.');
            }

            $authenticatable->fill($this->getPayload());

            $saved = $authenticatable->save();

            if (!$saved) {
                throw new \RuntimeException('Unable to save authenticatable.');
            }

            return $authenticatable;
        });
    }

    public function createAuthenticatableJsonApiResource(Authenticatable $authenticatable): JsonApiResourceInterface
    {
        return AuthJsonApiResource::inject(['authenticatable' => $authenticatable]);
    }

    /**
     * @param array<array-key, mixed> $credentials
     *
     * @return iterable<array-key, mixed>
     */
    public function createCredentialsAuthorizationContext(array $credentials): iterable
    {
        yield 'scope' => $this->getScope();

        yield 'credentials' => $credentials;
    }

    /**
     * @param array<array-key, mixed> $rules
     */
    public function createValidator(array $rules): Validator
    {
        return $this->getValidationFactory()->make($this->getValidationData(), $rules, $this->getValidationMessages(), $this->getValidationAttributes());
    }

    public function getAuthManager(): AuthManager
    {
        return Resolver::authManager();
    }

    public function getAuthenticatable(): Authenticatable|null
    {
        return \once(static fn(): Authenticatable|null => Resolver::authenticatableContract());
    }

    public function getAuthenticatableValidity(): AuthenticatableValidity
    {
        return AuthenticatableValidity::inject();
    }

    public function getAuthenticateAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['authenticate_ability'] ?? true;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    public function getCredentialsAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['credentials_ability'] ?? false;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    /**
     * @return iterable<array-key, array<array-key, mixed>>
     */
    public function getCredentialsToAuthorize(): iterable
    {
        yield [
            'email' => $this->getEmail(),
        ];
    }

    public function getEloquentUserProvider(): EloquentUserProvider
    {
        return Assert::instance($this->getUserProvider(), EloquentUserProvider::class);
    }

    public function getEmail(): string
    {
        return Filter::string($this->createValidator([
            'email' => $this->getAuthenticatableValidity()->email()->required()->compile(),
        ])->validate()['email'] ?? null);
    }

    public function getGate(): Gate
    {
        return Resolver::gate();
    }

    public function getGuard(): mixed
    {
        return $this->getAuthManager()->guard();
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return $this->createAuthenticatableJsonApiResource($this->createAuthenticatable());
    }

    public function getJsonApiDocument(): JsonApiDocumentInterface
    {
        return Resolver::inject(JsonApiDocument::class, ['data' => $this->getJsonApiData()]);
    }

    public function getJsonApiResponseFactory(): JsonApiResponseFactory
    {
        return JsonApiResponseFactory::inject();
    }

    public function getLocale(): string
    {
        return Filter::string($this->createValidator([
            'locale' => $this->getAuthenticatableValidity()->locale()->required()->compile(),
        ])->validate()['locale'] ?? null);
    }

    public function getLoginAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['login_ability'] ?? true;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    public function getPassword(): string
    {
        return Filter::string($this->createValidator([
            'password' => $this->getAuthenticatableValidity()->password()->required()->compile(),
        ])->validate()['password'] ?? null);
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getPayload(): array
    {
        return [
            'email' => $this->getEmail(),
            'locale' => $this->getLocale(),
            'password' => $this->getPassword(),
        ];
    }

    public function getRemember(): bool
    {
        return Filter::bool($this->createValidator([
            'remember' => $this->getAuthenticatableValidity()->remember()->required()->compile(),
        ])->validate()['remember'] ?? null);
    }

    public function getRequest(): Request
    {
        return Resolver::request();
    }

    public function getResponse(): JsonResponse|RedirectResponse|Response
    {
        return $this->getJsonApiResponseFactory()->json($this->getJsonApiDocument());
    }

    public function getRoute(): Route
    {
        return $this->getRouter()->current() ?? throw new \LogicException('Unable to get current route.');
    }

    public function getRouter(): Router
    {
        return Resolver::router();
    }

    public function getScope(): string
    {
        return Assert::string($this->getRoute()->defaults['scope'] ?? 'credentials_verification');
    }

    public function getSessionId(): string
    {
        if ($this->getRequest()->hasSession()) {
            return $this->getRequest()->session()->getId();
        }

        return Filter::string($this->createValidator([
            'session_id' => $this->getVerificationValidity()->sessionId()->required()->compile(),
        ])->validate()['session_id'] ?? null);
    }

    public function getThrower(): Thrower
    {
        return Thrower::inject(['validator' => $this->createValidator([])]);
    }

    public function getTrans(): Trans
    {
        return Trans::inject();
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

    /**
     * @return array<array-key, mixed>
     */
    public function getValidationAttributes(): array
    {
        return [];
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getValidationData(): array
    {
        return $this->getRequest()->all();
    }

    public function getValidationFactory(): Factory
    {
        return Resolver::validationFactory();
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getValidationMessages(): array
    {
        return [];
    }

    public function getVerificationValidity(): VerificationValidity
    {
        return VerificationValidity::inject();
    }

    public function getVerificator(): VerificatorInterface
    {
        return Verificator::inject();
    }

    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authenticate();

        $this->uniqueCredentials();

        if ($this->shouldAuthorizeCredentials()) {
            $this->authorizeCredentials();
        }

        if ($this->shouldLogin()) {
            $this->login();
            $this->regenerateSession();
        }

        return $this->getResponse();
    }

    public function login(): void
    {
        $guard = $this->getGuard();

        if ($guard instanceof StatefulGuard) {
            $guard->login($this->createAuthenticatable(), $this->getRemember());
        } elseif ($guard instanceof UnlimitedTokenGuard) {
            $guard->login($this->createAuthenticatable());
        } else {
            throw new \LogicException('Unsupported guard.');
        }
    }

    public function regenerateSession(): void
    {
        $request = $this->getRequest();

        if (!$request->hasSession()) {
            return;
        }

        $session = $request->session();

        $regenerated = $session->regenerate();

        if (!$regenerated) {
            throw new \RuntimeException('Unable to regenerate session');
        }
    }

    public function shouldAuthorizeCredentials(): bool
    {
        $ability = $this->getCredentialsAbility();

        if (\is_bool($ability)) {
            return !$ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->denies($ability);
    }

    public function shouldLogin(): bool
    {
        $ability = $this->getLoginAbility();

        if (\is_bool($ability)) {
            return $ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->allows($ability);
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
