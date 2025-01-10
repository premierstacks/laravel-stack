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

namespace Premierstacks\LaravelStack\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue as ShouldQueueContract;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Premierstacks\LaravelStack\Container\InjectTrait;

class TestMailNotification extends Notification implements ShouldQueueContract
{
    use InjectTrait;
    use Queueable;

    public function __construct()
    {
        $this->afterCommit();
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())->line('This is a test notification.');
    }

    /**
     * @return array<array-key, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }
}
