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
use Premierstacks\LaravelStack\Auth\Http\JsonApi\SessionJsonApiResource;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;
use Premierstacks\PhpStack\Mixed\Assert;

class SessionInvalidateController
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
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>
     */
    public function getJsonApiData(): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable
    {
        return SessionJsonApiResource::inject(['session' => $this->getRequest()->session()]);
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

    public function handle(): JsonResponse|RedirectResponse|Response
    {
        $this->authenticate();

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
}
