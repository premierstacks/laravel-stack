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
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class ValidateAcceptHeaderMiddleware
{
    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string ...$accepts): SymfonyResponse
    {
        if ($request->accepts($accepts)) {
            return $next($request);
        }

        throw new NotAcceptableHttpException();
    }
}
