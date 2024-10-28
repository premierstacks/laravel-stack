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
