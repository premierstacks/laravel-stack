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
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\LaravelStack\Verification\VerificationInterface;
use Premierstacks\PhpStack\Http\Uri;

class VerificationNotification extends Notification implements ShouldQueueContract
{
    use InjectTrait;
    use Queueable;

    public function __construct(public VerificationInterface $verification, public string $url, public string $email, public string $token)
    {
        $this->afterCommit();
    }

    public function getAction(): string
    {
        $trans = $this->getTrans();
        $action = $this->verification->getAction();

        if ($trans->has($action)) {
            return $trans->string($action);
        }

        if ($trans->has("actions.{$action}.title")) {
            return $trans->string("actions.{$action}.title");
        }

        if ($trans->has("psls::actions.{$action}.title")) {
            return $trans->string("psls::actions.{$action}.title");
        }

        return $action;
    }

    public function getTrans(): Trans
    {
        return Trans::inject();
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $trans = $this->getTrans();
        $class = static::class;

        $variant = \mb_strlen($this->token) > 10 ? 'token' : 'code';

        return (new MailMessage())
            ->subject($trans->string("notifications.{$class}.{$variant}.subject"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_1_title"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_1"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_2_title"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_2", ['action' => $this->getAction()]))
            ->line($trans->string("notifications.{$class}.{$variant}.line_3_title"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_3", ['pair' => $this->verification->getPair()]))
            ->line($trans->string("notifications.{$class}.{$variant}.line_4_title"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_4"))
            ->action($trans->string("notifications.{$class}.{$variant}.button"), $this->getUrl($notifiable))
            ->line($trans->string("notifications.{$class}.{$variant}.line_expiration_title"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_expiration", ['minutes' => (string) $this->verification->getExpiresAt()->diffInMinutes()]))
            ->line($trans->string("notifications.{$class}.{$variant}.line_not_you_title"))
            ->line($trans->string("notifications.{$class}.{$variant}.line_not_you"));
    }

    /**
     * @return array<array-key, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    protected function getUrl(mixed $notifiable): string
    {
        return (string) Uri::newFromString($this->url)->mergeQuery([
            'verification_id' => $this->verification->getVerificationId(),
            'token' => $this->token,
            '_accept_language' => $this->locale,
        ]);
    }
}
