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

namespace Premierstacks\LaravelStack\Http\Middleware;

use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Throttle\Limit;
use Premierstacks\LaravelStack\Throttle\Limiter;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ThrottlePassMiddleware
{
    public function createLimit(string $key, int $attempts, int $seconds): Limit
    {
        return Limit::dependency($key, $attempts, $seconds);
    }

    public function createLimiter(Limit $limit): Limiter
    {
        return Limiter::inject(['limit' => $limit]);
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string $key = '', int $attempts = 5, int $seconds = 600): SymfonyResponse
    {
        $throttler = $this->createLimiter($this->createLimit($key, $attempts, $seconds))->authorize();

        $passed = $next($request);

        if ($passed->getStatusCode() < 400) {
            $throttler->hit();
        }

        return $passed;
    }
}
