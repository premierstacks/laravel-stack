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
use Premierstacks\LaravelStack\Container\Resolver;

class ScoutSyncCommand extends Command
{
    protected $description = 'Synchronize Scout with the database.';

    protected $signature = 'psls:scout:sync';

    public function handle(): int
    {
        $this->call('scout:sync-index-settings');

        $classes = Resolver::filesystem()->files(Resolver::application()->path('Models'));

        $namespace = Resolver::applicationContract()->getNamespace();

        foreach ($classes as $class) {
            try {
                $this->call('scout:flush', ['model' => "{$namespace}\\Models\\{$class->getBasename('.php')}"]);
                $this->call('scout:import', ['model' => "{$namespace}\\Models\\{$class->getBasename('.php')}"]);
            } catch (\BadMethodCallException) {
            }
        }

        return 0;
    }
}