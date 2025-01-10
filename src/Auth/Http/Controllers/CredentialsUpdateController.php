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

use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
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

class CredentialsUpdateController
{
    public function authenticate(): void
    {
        $authenticatable = $this->getAuthenticatable();

        $ability = $this->getAuthenticateAbility();

        if ($ability === true) {
            return;
        }

        if ($ability === false) {
            throw new AuthenticationException();
        }

        $gate = $this->getGate()->forUser($authenticatable);

        $gate->authorize($ability);
    }

    public function authorizePassword(): void
    {
        if (!$this->getHasher()->check($this->getPassword(), $this->getAuthenticatable()->getAuthPassword())) {
            $this->getThrower()->errors(['password'], $this->getTrans()->string('auth.password'))->throw(403);
        }
    }

    public function authorizeVerificator(): void
    {
        $verificator = $this->getVerificator();

        $verification = $verificator->retrieveActive($this->getSessionId(), $this->getVerificationContext());

        if ($verification === null || !$verificator->decrementUses($verification)) {
            $this->getThrower()->failures(['session_id'], 'Confirmed')->throw(403);
        }
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

    public function getAuthenticatable(): Authenticatable
    {
        return \once(static fn(): Authenticatable => Resolver::authenticatableContract() ?? throw new AuthenticationException(guards: [null]));
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

    public function getHasher(): Hasher
    {
        return Resolver::hasherContract();
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return AuthJsonApiResource::inject(['authenticatable' => $this->getAuthenticatable()]);
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

    public function getPasswordAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['password_ability'] ?? false;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getPayload(): array
    {
        return [
            'email' => $this->getEmail(),
        ];
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
        return Assert::string($this->getRoute()->defaults['scope'] ?? 'credentials_update');
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

    /**
     * @return iterable<array-key, mixed>
     */
    public function getVerificationContext(): iterable
    {
        $authenticatable = $this->getAuthenticatable();

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

    public function getVerificatorAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['verificator_ability'] ?? false;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
    }

    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authenticate();

        if ($this->shouldAuthorizePassword()) {
            $this->authorizePassword();
        }

        if ($this->shouldAuthorizeVerificator()) {
            $this->authorizeVerificator();
        }

        $this->uniqueCredentials();

        $this->updateCredentials();

        $this->regenerateSession();

        return $this->getResponse();
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

    public function shouldAuthorizePassword(): bool
    {
        $ability = $this->getPasswordAbility();

        if (\is_bool($ability)) {
            return !$ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->denies($ability);
    }

    public function shouldAuthorizeVerificator(): bool
    {
        $ability = $this->getVerificatorAbility();

        if (\is_bool($ability)) {
            return !$ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->denies($ability);
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

    public function updateCredentials(): void
    {
        $authenticatable = $this->getAuthenticatable();

        if (!$authenticatable instanceof Model) {
            throw new \LogicException('Authenticatable must be an model');
        }

        $updated = $authenticatable->update($this->getPayload());

        if (!$updated) {
            throw new \RuntimeException('Unable to update authenticatable');
        }
    }
}
