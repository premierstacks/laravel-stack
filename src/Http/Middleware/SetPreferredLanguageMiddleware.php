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

class SetPreferredLanguageMiddleware
{
    public function getConf(): Conf
    {
        return Conf::inject();
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string ...$locales): SymfonyResponse
    {
        $conf = $this->getConf();

        if ($locales === []) {
            $locales = $conf->getAppLocales();
        }

        $locale = null;

        $query = $request->query->getString('_accept_language');

        if (\in_array($query, $locales, true)) {
            $locale = $query;
        }

        if ($locale === null) {
            $locale = $request->getPreferredLanguage($locales);
        }

        if ($locale === null) {
            return $next($request);
        }

        if ($locale !== $conf->getAppLocale()) {
            $conf->setAppLocale($locale);
        }

        if ($locale !== $request->getLocale()) {
            $request->setLocale($locale);
        }

        return $next($request);
    }
}
