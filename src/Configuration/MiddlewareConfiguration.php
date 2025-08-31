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

namespace Premierstacks\LaravelStack\Configuration;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Kernel as VendorHttpKernel;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Premierstacks\LaravelStack\Http\Middleware\SetPreferredLanguageMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\SetRequestFormatMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ValidateAcceptHeaderMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ValidateContentTypeHeaderMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ValidationFactoryMiddleware;
use Premierstacks\LaravelStack\Validation\Validators\ApiValidator;

class MiddlewareConfiguration extends VendorHttpKernel
{
    public static function configure(Middleware $middleware): void
    {
        $middleware->prepend([
            SetPreferredLanguageMiddleware::class,
        ]);

        $middleware->redirectTo('/', '/');

        $middleware->group('session', [
            StartSession::class,
            ShareErrorsFromSession::class,
        ]);

        $middleware->group('encrypted_cookies', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
        ]);

        $middleware->group('api_form_json', [
            ValidationFactoryMiddleware::class . ':' . ApiValidator::class,
            SetRequestFormatMiddleware::class . ':json',
            ValidateAcceptHeaderMiddleware::class . ':application/json',
            ValidateContentTypeHeaderMiddleware::class . ':form',
        ]);

        $middleware->trimStrings(['current_password', 'current_password_confirmation', 'password', 'password_confirmation', 'new_password', 'new_password_confirmation']);
    }
}
