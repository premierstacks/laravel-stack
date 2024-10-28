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
