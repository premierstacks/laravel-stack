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
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
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

class LoginController
{
    public function authorize(): void
    {
        $gate = $this->getGate()->forUser($this->retrieveAuthenticatable());
        $scope = $this->getScope();

        if ($gate->has($scope)) {
            $gate->authorize($scope);
        }
    }

    public function authorizeMultifactor(): void
    {
        if (!$this->getVerificator()->decrement($this->getSessionId(), $this->getVerificationContext())) {
            $this->getThrower()->failures(['session_id'], 'Confirmed')->throw(403);
        }
    }

    public function authorizePassword(): void
    {
        if (!$this->getHasher()->check($this->getPassword(), $this->retrieveAuthenticatable()->getAuthPassword())) {
            $this->getThrower()->errors(['password'], $this->getTrans()->string('auth.password'))->throw(403);
        }
    }

    public function createAuthJsonApiResource(Authenticatable $authenticatable): JsonApiResourceInterface
    {
        return AuthJsonApiResource::inject(['authenticatable' => $authenticatable]);
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

    public function getAuthenticatableValidity(): AuthenticatableValidity
    {
        return AuthenticatableValidity::inject();
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

    public function getHasher(): Hasher
    {
        return Resolver::hasherContract();
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return $this->createAuthJsonApiResource($this->retrieveAuthenticatable());
    }

    public function getJsonApiDocument(): JsonApiDocumentInterface
    {
        return Resolver::inject(JsonApiDocument::class, ['data' => $this->getJsonApiData()]);
    }

    public function getJsonApiResponseFactory(): JsonApiResponseFactory
    {
        return JsonApiResponseFactory::inject();
    }

    public function getPassword(): string
    {
        return Filter::string($this->createValidator([
            'password' => $this->getAuthenticatableValidity()->password()->required()->compile(),
        ])->validate()['password'] ?? null);
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

    /**
     * @return iterable<array-key, array<array-key, mixed>>
     */
    public function getRetrieveCredentials(): iterable
    {
        yield [
            'email' => $this->getEmail(),
        ];
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
        return Assert::string($this->getRoute()->defaults['scope'] ?? 'login');
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

    /**
     * @return iterable<array-key, mixed>
     */
    public function getVerificationContext(): iterable
    {
        $authenticatable = $this->retrieveAuthenticatable();

        yield 'scope' => $this->getScope();

        yield 'authenticatable' => [
            'id' => $authenticatable->getAuthIdentifier(),
            'class' => $authenticatable::class,
            'password' => $authenticatable->getAuthPassword(),
        ];
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
        $this->authorize();

        if ($this->shouldAuthorizePassword()) {
            $this->authorizePassword();
        }

        if ($this->shouldAuthorizeMultifactor()) {
            $this->authorizeMultifactor();
        }

        $this->login();

        $this->regenerateSession();

        return $this->getResponse();
    }

    public function login(): void
    {
        $guard = $this->getGuard();

        if ($guard instanceof StatefulGuard) {
            $guard->login($this->retrieveAuthenticatable(), $this->getRemember());
        } elseif ($guard instanceof UnlimitedTokenGuard) {
            $guard->login($this->retrieveAuthenticatable());
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

    public function shouldAuthorizeMultifactor(): bool
    {
        $gate = $this->getGate()->forUser($this->retrieveAuthenticatable());
        $scope = $this->getScope();

        if ($gate->has("{$scope}_multifactor_authorization")) {
            return $gate->allows("{$scope}_multifactor_authorization");
        }

        if ($gate->has('multifactor_authorization')) {
            return $gate->allows('multifactor_authorization');
        }

        return true;
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
