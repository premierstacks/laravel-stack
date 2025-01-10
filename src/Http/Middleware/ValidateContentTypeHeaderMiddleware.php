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
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class ValidateContentTypeHeaderMiddleware
{
    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string ...$contentTypes): SymfonyResponse
    {
        if ($request->isMethodSafe()) {
            return $next($request);
        }

        $contentType = $request->getContentTypeFormat();

        if (\in_array($contentType, $contentTypes, true)) {
            return $next($request);
        }

        if ($contentType === null && \in_array($request->getContent(), [null, false, ''], true)) {
            return $next($request);
        }

        throw new UnsupportedMediaTypeHttpException();
    }
}
