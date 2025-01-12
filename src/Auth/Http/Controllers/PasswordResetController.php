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
use Illuminate\Contracts\Auth\StatefulGuard;
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
use Premierstacks\LaravelStack\Auth\Guards\UnlimitedTokenGuard;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\AuthJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\Validation\AuthenticatableValidity;
use Premierstacks\LaravelStack\Auth\Http\Validation\VerificationValidity;
use Premierstacks\LaravelStack\Container\Resolve;
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

class PasswordResetController
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
        return Resolve::authManager();
    }

    public function getAuthenticatable(): Authenticatable|null
    {
        return \once(static fn(): Authenticatable|null => Resolve::authenticatableContract());
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

    public function getAuthorizeAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['authorize_ability'] ?? true;

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
        return Resolve::gate();
    }

    public function getGuard(): mixed
    {
        return $this->getAuthManager()->guard();
    }

    public function getHasher(): Hasher
    {
        return Resolve::hasherContract();
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return AuthJsonApiResource::inject(['authenticatable' => $this->retrieveAuthenticatable()]);
    }

    public function getJsonApiDocument(): JsonApiDocumentInterface
    {
        return Resolve::inject(JsonApiDocument::class, ['data' => $this->getJsonApiData()]);
    }

    public function getJsonApiResponseFactory(): JsonApiResponseFactory
    {
        return JsonApiResponseFactory::inject();
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
        return Resolve::request();
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
        return Resolve::router();
    }

    public function getScope(): string
    {
        return Assert::string($this->getRoute()->defaults['scope'] ?? 'password_reset');
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
        return Resolve::validationFactory();
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
        $this->authenticate();
        $this->authorize();

        $this->authorizeVerificator();

        $this->updatePassword();

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

    public function shouldLogin(): bool
    {
        $ability = $this->getLoginAbility();

        if (\is_bool($ability)) {
            return $ability;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());

        return $gate->allows($ability, $this->retrieveAuthenticatable());
    }

    public function updatePassword(): void
    {
        $authenticatable = $this->retrieveAuthenticatable();

        if (!$authenticatable instanceof Model) {
            throw new \LogicException('Authenticatable must be an model');
        }

        $updated = $authenticatable->update($this->getPayload());

        if (!$updated) {
            throw new \RuntimeException('Unable to update authenticatable');
        }
    }
}
