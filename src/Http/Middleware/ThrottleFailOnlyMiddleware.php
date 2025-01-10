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

namespace Premierstacks\LaravelStack\Http\Middleware;

use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Exceptions\ExceptionHandler;
use Premierstacks\LaravelStack\Throttle\Limit;
use Premierstacks\LaravelStack\Throttle\Limiter;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ThrottleFailOnlyMiddleware
{
    public function createLimit(string $key, int $attempts, int $seconds): Limit
    {
        return Limit::dependency($key, $attempts, $seconds);
    }

    public function createLimiter(Limit $limit): Limiter
    {
        return Limiter::inject(['limit' => $limit]);
    }

    public function getExceptionHandler(): ExceptionHandler
    {
        return ExceptionHandler::inject();
    }

    public function getThrowableStatusCode(\Throwable $throwable): int
    {
        return $this->getExceptionHandler()->getThrowableStatusCode($throwable);
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string $key = '', int $attempts = 5, int $seconds = 600, string ...$only): SymfonyResponse
    {
        $throttler = $this->createLimiter($this->createLimit($key, $attempts, $seconds))->authorize();

        try {
            $passed = $next($request);
        } catch (\Throwable $throwable) {
            if ($this->shouldHitThrowable($throwable, $only)) {
                $throttler->hit();
            }

            throw $throwable;
        }

        if ($this->shouldHitStatusCode($passed->getStatusCode(), $only)) {
            $throttler->hit();
        }

        return $passed;
    }

    /**
     * @param array<array-key, string> $only
     */
    public function shouldHitStatusCode(int $statusCode, array $only): bool
    {
        return \in_array((string) $statusCode, $only, true);
    }

    /**
     * @param array<array-key, string> $only
     */
    public function shouldHitThrowable(\Throwable $throwable, array $only): bool
    {
        return \in_array($throwable::class, $only, true) || $this->shouldHitStatusCode($this->getThrowableStatusCode($throwable), $only);
    }
}
