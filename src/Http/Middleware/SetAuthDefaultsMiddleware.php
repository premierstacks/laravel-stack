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
