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

use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\PhpStack\Mixed\Assert;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SmartTransactionMiddleware
{
    public function getConnection(): ConnectionInterface
    {
        return Resolver::databaseConnectionContract();
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, int $attempts = 1): SymfonyResponse
    {
        if ($request->isMethodSafe()) {
            return $next($request);
        }

        return Assert::instance($this->getConnection()->transaction(static fn(): SymfonyResponse => $next($request), $attempts), SymfonyResponse::class);
    }
}
