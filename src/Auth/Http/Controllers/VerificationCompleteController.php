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
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\VerificationJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\Validation\VerificationValidity;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Exceptions\Thrower;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\LaravelStack\Verification\VerificationInterface;
use Premierstacks\LaravelStack\Verification\Verificator;
use Premierstacks\LaravelStack\Verification\VerificatorInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;
use Premierstacks\PhpStack\Mixed\Filter;

class VerificationCompleteController
{
    public function complete(): void
    {
        $verification = $this->getVerification();

        if ($verification->isCompleted()) {
            $this->getThrower()->failures(['verification_id'], 'Can')->throw(409);
        }

        if (!$verification->isReady()) {
            $this->getThrower()->failures(['verification_id'], 'Can')->throw(403);
        }

        if (!$verification->validateToken($this->getToken())) {
            $this->getThrower()->failures(['token'], 'Exists')->throw(422);
        }

        if (!$this->getVerificator()->complete($verification)) {
            $this->getThrower()->failures(['token'], 'Exists')->throw(404);
        }
    }

    /**
     * @param array<array-key, mixed> $rules
     */
    public function createValidator(array $rules): Validator
    {
        return $this->getValidationFactory()->make($this->getValidationData(), $rules, $this->getValidationMessages(), $this->getValidationAttributes());
    }

    public function createVerificationJsonApiResource(VerificationInterface $verification): JsonApiResourceInterface
    {
        return VerificationJsonApiResource::inject(['verification' => $verification]);
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return $this->createVerificationJsonApiResource($this->getVerification());
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

    public function getThrower(): Thrower
    {
        return Thrower::inject(['validator' => $this->createValidator([])]);
    }

    public function getToken(): string
    {
        return Filter::string($this->createValidator([
            'token' => $this->getVerificationValidity()->token()->required()->compile(),
        ])->validate()['token'] ?? null);
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

    public function getVerification(): VerificationInterface
    {
        return $this->getVerificator()->retrieveByVerificationId($this->getVerificationId()) ?? $this->getThrower()->failures(['verification_id'], 'Exists')->throw(404);
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
        $this->complete();

        return $this->getResponse();
    }
}
