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
use Premierstacks\LaravelStack\Config\Conf;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SetAuthDefaultsMiddleware
{
    public function getConf(): Conf
    {
        return Conf::inject();
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string ...$guards): SymfonyResponse
    {
        $want = $request->headers->get('X-Auth-Defaults') ?? $guards[0] ?? null;

        if (!\in_array($want, $guards, true)) {
            throw new BadRequestHttpException('X-Auth-Defaults');
        }

        $conf = $this->getConf();

        if ($want !== $conf->getAuthDefaultsGuard()) {
            $conf->setAuthDefaultsGuard($want);
        }

        if ($want !== $conf->getAuthDefaultsPasswords()) {
            $conf->setAuthDefaultsPasswords($want);
        }

        if ($want !== $conf->getAuthDefaultsProvider()) {
            $conf->setAuthDefaultsProvider($want);
        }

        return $next($request);
    }
}
