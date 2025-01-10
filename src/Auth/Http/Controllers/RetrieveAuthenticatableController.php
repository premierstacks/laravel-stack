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
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\AuthenticatableJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\Validation\AuthenticatableValidity;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Exceptions\Thrower;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class RetrieveAuthenticatableController
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

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function createAuthenticatableJsonApiResource(Authenticatable $authenticatable): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        return AuthenticatableJsonApiResource::inject(['authenticatable' => $authenticatable]);
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function createGuestJsonApiResource(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        $retrieveCredentials = \iterator_to_array($this->getRetrieveCredentials());

        $this->getThrower()->errors(\array_keys(\array_reduce($retrieveCredentials, 'array_merge', [])), $this->getTrans()->string('auth.failed'))->throw(404);
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

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        $authenticatable = $this->retrieveAuthenticatable();

        if ($authenticatable !== null) {
            return $this->createAuthenticatableJsonApiResource($authenticatable);
        }

        return $this->createGuestJsonApiResource();
    }

    public function getJsonApiDocument(): JsonApiDocumentInterface
    {
        return Resolver::inject(JsonApiDocument::class, ['data' => $this->getJsonApiData()]);
    }

    public function getJsonApiResponseFactory(): JsonApiResponseFactory
    {
        return JsonApiResponseFactory::inject();
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

    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authenticate();

        return $this->getResponse();
    }

    public function retrieveAuthenticatable(): Authenticatable|null
    {
        return \once(function (): Authenticatable|null {
            $retrieveCredentials = $this->getRetrieveCredentials();
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

            return null;
        });
    }
}
