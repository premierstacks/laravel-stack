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

namespace Premierstacks\LaravelStack\Commands;

use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;
use Premierstacks\LaravelStack\Notifications\TestMailNotification;
use Premierstacks\PhpStack\Mixed\Filter;

class DebugMailCommand extends Command
{
    protected $description = 'Debug mail command';

    protected $signature = 'psls:debug:mail';

    public function handle(): int
    {
        $email = Filter::string($this->ask('Target e-mail address.'));

        (new AnonymousNotifiable())->route('mail', $email)->notifyNow(new TestMailNotification());

        $this->info('Debugging e-mail notification sent.');

        return 0;
    }
}
