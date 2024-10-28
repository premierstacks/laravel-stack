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
