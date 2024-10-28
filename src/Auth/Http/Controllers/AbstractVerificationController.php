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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\VerificationJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\Validation\AuthenticatableValidity;
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
use Premierstacks\PhpStack\Random\Random;

abstract class AbstractVerificationController
{
    /**
     * @param array<array-key, mixed> $rules
     */
    public function createValidator(array $rules): Validator
    {
        return $this->getValidationFactory()->make($this->getValidationData(), $rules, $this->getValidationMessages(), $this->getValidationAttributes());
    }

    public function createVerification(): VerificationInterface
    {
        return \once(fn(): VerificationInterface => $this->getVerificator()->createVerification($this->getSessionId(), $this->getVerificationId(), $this->getToken(), $this->getPair(), $this->getContext(), $this->getAction(), $this->getExpiresAt(), $this->getDuration(), $this->getUses(), null));
    }

    public function createVerificationJsonApiResource(VerificationInterface $verification): JsonApiResourceInterface
    {
        return VerificationJsonApiResource::inject(['verification' => $verification]);
    }

    public function getAction(): string
    {
        return Assert::string($this->getRoute()->defaults['action'] ?? $this->getScope());
    }

    public function getAuthenticatableValidity(): AuthenticatableValidity
    {
        return AuthenticatableValidity::inject();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getContext(): iterable
    {
        yield from $this->getScopeContext();
    }

    public function getDuration(): int
    {
        return 600;
    }

    public function getExpiresAt(): Carbon
    {
        return Carbon::now()->addSeconds(600);
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return $this->createVerificationJsonApiResource($this->createVerification());
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

    public function getPair(): string
    {
        return Random::code(4);
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
        return Assert::string($this->getRoute()->defaults['scope'] ?? 'action_authorization');
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getScopeContext(): iterable
    {
        yield 'scope' => $this->getScope();
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

    public function getToken(): string
    {
        return Random::alnum();
    }

    public function getUses(): int
    {
        return 1;
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

    public function getVerificationId(): string
    {
        return Random::alnum();
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
        $this->notify();

        return $this->getResponse();
    }

    abstract public function notify(): void;
}
