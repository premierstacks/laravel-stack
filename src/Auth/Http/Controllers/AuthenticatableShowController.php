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

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\AuthJsonApiResource;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;

class AuthenticatableShowController
{
    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function createAuthenticatableJsonApiResource(Authenticatable $authenticatable): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        return AuthJsonApiResource::inject(['authenticatable' => $authenticatable]);
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function createGuestJsonApiResource(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        return null;
    }

    public function getAuthenticatable(): Authenticatable|null
    {
        return \once(static fn(): Authenticatable|null => Resolver::authenticatableContract());
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        $authenticatable = $this->getAuthenticatable();

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

    public function handle(): JsonResponse|RedirectResponse|Response
    {
        return $this->getResponse();
    }
}
