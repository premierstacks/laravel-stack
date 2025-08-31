<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolve;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\LaravelStack\JsonApi\ThrowableJsonApiErrors;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\PhpStack\JsonApi\JsonApiDocument;
use Premierstacks\PhpStack\Types\Strings;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionHandler extends Handler
{
    use InjectTrait;

    protected $dontFlash = ['current_password', 'current_password_confirmation', 'password', 'password_confirmation', 'new_password', 'new_password_confirmation', 'token', 'bearer_token', 'session_id', 'bearer'];

    public function convertThrowableToHttpException(\Throwable $e): HttpExceptionInterface
    {
        if ($e instanceof HttpExceptionInterface) {
            return $e;
        }

        return new HttpException($this->getThrowableStatusCode($e), $this->getThrowableTitle($e), $e, $this->getThrowableHeaders($e), $this->getThrowableCode($e));
    }

    public function createJsonResponse(Request $request, \Throwable $throwable): JsonResponse
    {
        $errors = Resolve::resolve(ThrowableJsonApiErrors::class, ThrowableJsonApiErrors::class, ['throwable' => $throwable]);
        $document = Resolve::resolve(JsonApiDocument::class, JsonApiDocument::class, ['errors' => $errors]);

        return $this->getJsonApiResponseFactory()->json($document, $this->getThrowableStatusCode($throwable), $this->getThrowableHeaders($throwable))->withException($throwable);
    }

    public function createSymfonyResponse(Request $request, \Throwable $throwable): RedirectResponse|Response
    {
        return $this->getResponseFactory()->make($this->renderExceptionContent($throwable), $this->getThrowableStatusCode($throwable), $this->getThrowableHeaders($throwable))->withException($throwable);
    }

    public function createViewResponse(Request $request, \Throwable $throwable): RedirectResponse|Response
    {
        $this->registerErrorViewPaths();

        $view = $this->getHttpExceptionView($this->convertThrowableToHttpException($throwable));

        if ($view !== null) {
            return $this->getResponseFactory()->view($view, [
                'errors' => new ViewErrorBag(),
                'exception' => $throwable,
            ], $this->getThrowableStatusCode($throwable), $this->getThrowableHeaders($throwable))->withException($throwable);
        }

        return $this->createSymfonyResponse($request, $throwable);
    }

    public function getConf(): Conf
    {
        return Conf::inject();
    }

    public function getJsonApiResponseFactory(): JsonApiResponseFactory
    {
        return JsonApiResponseFactory::inject();
    }

    public function getResponseFactory(): ResponseFactory
    {
        return Resolve::responseFactoryContract();
    }

    public function getThrowableCode(\Throwable $throwable): int
    {
        $code = $throwable->getCode();

        if (\is_int($code)) {
            return $code;
        }

        return 0;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getThrowableHeaders(\Throwable $throwable): array
    {
        return match (true) {
            $throwable instanceof HttpExceptionInterface => $throwable->getHeaders(),
            default => [],
        };
    }

    public function getThrowableStatusCode(\Throwable $throwable): int
    {
        return match (true) {
            $throwable instanceof HttpExceptionInterface => $throwable->getStatusCode(),
            $throwable instanceof AuthorizationException => $throwable->status() ?? 403,
            $throwable instanceof TokenMismatchException => 419,
            $throwable instanceof RequestExceptionInterface => 400,
            $throwable instanceof AuthenticationException => 401,
            $throwable instanceof ValidationException => $throwable->status,
            default => 500,
        };
    }

    public function getThrowableTitle(\Throwable $throwable): string
    {
        $trans = $this->getTrans();
        $message = Strings::nullify($throwable->getMessage());

        if ($message !== null && $trans->has($message)) {
            return $trans->string($message);
        }

        if ($message !== null && ($throwable instanceof HttpExceptionInterface || $throwable instanceof AuthorizationException || $throwable instanceof AuthenticationException)) {
            return $message;
        }

        $status = $this->getThrowableStatusCode($throwable);

        if ($trans->has("statuses.{$status}.title")) {
            return $trans->string("statuses.{$status}.title");
        }

        if ($trans->has("psls::statuses.{$status}.title")) {
            return $trans->string("psls::statuses.{$status}.title");
        }

        if ($trans->has('statuses.0.title')) {
            return $trans->string('statuses.0.title');
        }

        if ($trans->has('psls::statuses.0.title')) {
            return $trans->string('psls::statuses.0.title');
        }

        return 'ERROR';
    }

    public function getTrans(): Trans
    {
        return Trans::inject();
    }

    #[\Override]
    protected function invalid(mixed $request, ValidationException $exception): JsonResponse|RedirectResponse|Response
    {
        if ($request->hasSession()) {
            return parent::invalid($request, $exception);
        }

        return $this->prepareResponse($request, $exception);
    }

    #[\Override]
    protected function invalidJson(mixed $request, ValidationException $exception): JsonResponse
    {
        return $this->createJsonResponse($request, $exception);
    }

    #[\Override]
    protected function prepareException(\Throwable $e): \Throwable
    {
        return $e;
    }

    #[\Override]
    protected function prepareJsonResponse(mixed $request, \Throwable $e): JsonResponse
    {
        return $this->createJsonResponse($request, $e);
    }

    #[\Override]
    protected function prepareResponse(mixed $request, \Throwable $e): RedirectResponse|Response
    {
        if ($this->getConf()->getAppDebug()) {
            return $this->createSymfonyResponse($request, $e);
        }

        return $this->createViewResponse($request, $e);
    }

    #[\Override]
    protected function shouldReturnJson(mixed $request, \Throwable $e): bool
    {
        return parent::shouldReturnJson($request, $e) || $request->getRequestFormat() === 'json';
    }

    #[\Override]
    protected function unauthenticated(mixed $request, AuthenticationException $exception): JsonResponse|RedirectResponse|Response
    {
        if ($this->shouldReturnJson($request, $exception)) {
            return $this->createJsonResponse($request, $exception);
        }

        $redirect = $exception->redirectTo($request);

        if ($request->hasSession() && $redirect !== null) {
            return $this->getResponseFactory()->redirectGuest($redirect)->withException($exception);
        }

        return $this->prepareResponse($request, $exception);
    }
}
