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
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\VerificationJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\Validation\VerificationValidity;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\LaravelStack\Verification\VerificationInterface;
use Premierstacks\LaravelStack\Verification\Verificator;
use Premierstacks\LaravelStack\Verification\VerificatorInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerificationShowController
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
    public function createNotFoundJsonApiResource(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        throw new NotFoundHttpException();
    }

    /**
     * @param array<array-key, mixed> $rules
     */
    public function createValidator(array $rules): Validator
    {
        return $this->getValidationFactory()->make($this->getValidationData(), $rules, $this->getValidationMessages(), $this->getValidationAttributes());
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function createVerificationJsonApiResource(VerificationInterface $verification): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        return VerificationJsonApiResource::inject(['verification' => $verification]);
    }

    public function getAuthenticatable(): Authenticatable|null
    {
        return \once(static fn(): Authenticatable|null => Resolver::authenticatableContract());
    }

    public function getAuthenticateAbility(): bool|string
    {
        $ability = $this->getRoute()->defaults['authenticate_ability'] ?? true;

        if (\is_bool($ability)) {
            return $ability;
        }

        return Assert::string($ability);
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
        $verification = $this->getVerification();

        if ($verification === null) {
            return $this->createNotFoundJsonApiResource();
        }

        return $this->createVerificationJsonApiResource($verification);
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

    public function getResponse(): JsonResponse
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

    public function getVerification(): VerificationInterface|null
    {
        return $this->getVerificator()->retrieveByVerificationId($this->getVerificationId());
    }

    public function getVerificationId(): string
    {
        return Filter::string($this->createValidator([
            'verification_id' => $this->getVerificationValidity()->verificationId()->required()->compile(),
        ])->validate()['verification_id'] ?? null);
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

        return $this->getResponse();
    }
}
