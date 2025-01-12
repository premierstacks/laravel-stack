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

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Container\Resolve;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HasLocalePreferenceMiddleware
{
    public function getAuthenticatable(): Authenticatable|null
    {
        return Resolve::authenticatableContract();
    }

    public function getConf(): Conf
    {
        return Conf::inject();
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string ...$locales): SymfonyResponse
    {
        $authenticatable = $this->getAuthenticatable();

        if (!$authenticatable instanceof HasLocalePreference) {
            return $next($request);
        }

        $locale = $authenticatable->preferredLocale();

        if ($locale === null || ($locales !== [] && !\in_array($locale, $locales, true))) {
            return $next($request);
        }

        $conf = $this->getConf();

        if ($locale !== $conf->getAppLocale()) {
            $conf->setAppLocale($locale);
        }

        if ($locale !== $request->getLocale()) {
            $request->setLocale($locale);
        }

        return $next($request);
    }
}
