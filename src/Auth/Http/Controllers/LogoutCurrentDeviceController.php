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
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
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
use Premierstacks\PhpStack\JsonApi\NullJsonApiResource;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class LogoutCurrentDeviceController
{
    public function authorize(): void
    {
        $gate = $this->getGate()->forUser($this->getAuthenticatable());
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
        if (!$this->getHasher()->check($this->getPassword(), $this->getAuthenticatable()->getAuthPassword())) {
            $this->getThrower()->errors(['password'], $this->getTrans()->string('auth.password'))->throw(403);
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
        return new NullJsonApiResource();
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

    public function getRequest(): Request
    {
        return Resolver::request();
    }

    public function getResponse(): JsonResponse|RedirectResponse|Response
    {
        return $this->getJsonApiResponseFactory()->json($this->getJsonApiDocument(), null, [
            'Clear-Site-Data' => '"*"',
        ]);
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
        return Assert::string($this->getRoute()->defaults['scope'] ?? 'logout_current_device');
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

    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authorize();

        if ($this->shouldAuthorizePassword()) {
            $this->authorizePassword();
        }

        if ($this->shouldAuthorizeMultifactor()) {
            $this->authorizeMultifactor();
        }

        $this->logoutCurrentDevice();

        $this->invalidateSession();

        return $this->getResponse();
    }

    public function invalidateSession(): void
    {
        $session = $this->getRequest()->session();

        $invalidated = $session->invalidate();

        if (!$invalidated) {
            throw new \RuntimeException('Unable to invalidate session');
        }

        $session->regenerateToken();
    }

    public function logoutCurrentDevice(): void
    {
        $guard = $this->getGuard();

        if ($guard instanceof SessionGuard) {
            $guard->logoutCurrentDevice();
        } elseif ($guard instanceof StatefulGuard) {
            $guard->logout();
        } elseif ($guard instanceof UnlimitedTokenGuard) {
            $guard->logoutCurrentDevice();
        }
    }

    public function shouldAuthorizeMultifactor(): bool
    {
        $gate = $this->getGate()->forUser($this->getAuthenticatable());
        $scope = $this->getScope();

        if ($gate->has("{$scope}_multifactor_authorization")) {
            return $gate->allows("{$scope}_multifactor_authorization");
        }

        if ($gate->has('multifactor_authorization')) {
            return $gate->allows('multifactor_authorization');
        }

        return false;
    }

    public function shouldAuthorizePassword(): bool
    {
        if ($this->getGuard() instanceof SessionGuard) {
            return true;
        }

        $gate = $this->getGate()->forUser($this->getAuthenticatable());
        $scope = $this->getScope();

        if ($gate->has("{$scope}_password_authorization")) {
            return $gate->allows("{$scope}_password_authorization");
        }

        if ($gate->has('password_authorization')) {
            return $gate->allows('password_authorization');
        }

        return false;
    }
}
