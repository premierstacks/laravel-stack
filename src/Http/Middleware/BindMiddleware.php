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

use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Container\Resolve;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class BindMiddleware
{
    public function getContainer(): ContainerContract
    {
        return Resolve::containerContract();
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string $abstract, string|null $concrete = null, bool $shared = false): SymfonyResponse
    {
        $this->getContainer()->bind($abstract, $concrete, $shared);

        return $next($request);
    }
}
