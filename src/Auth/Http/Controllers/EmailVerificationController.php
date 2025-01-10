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

namespace Premierstacks\LaravelStack\Auth\Http\Controllers;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Premierstacks\LaravelStack\Notifications\VerificationNotification;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class EmailVerificationController extends AbstractVerificationController
{
    public function createNotification(): Notification
    {
        $verification = $this->createVerification();

        return VerificationNotification::inject([
            'verification' => $verification,
            'url' => $this->getUrl(),
            'email' => $this->getEmail(),
            'token' => Assert::string($verification->getToken()),
        ])->locale($this->getLocale());
    }

    public function getEmail(): string
    {
        return Filter::string($this->createValidator([
            'email' => $this->getAuthenticatableValidity()->email()->required()->compile(),
        ])->validate()['email'] ?? null);
    }

    public function getUrl(): string
    {
        return Filter::string($this->createValidator([
            'url' => $this->getVerificationValidity()->url()->required()->compile(),
        ])->validate()['url'] ?? null);
    }

    #[\Override]
    public function notify(): void
    {
        (new AnonymousNotifiable())->route('mail', $this->getEmail())->notify($this->createNotification());
    }
}
