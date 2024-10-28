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

use Illuminate\Console\GeneratorCommand;

class ValidityGeneratorCommand extends GeneratorCommand
{
    protected $description = 'Create a new custom Validity class';

    protected $name = 'psls:make:validity';

    protected $type = 'Validity';

    #[\Override]
    protected function getDefaultNamespace(mixed $rootNamespace): string
    {
        return parent::getDefaultNamespace($rootNamespace) . '\Http\Validation\Validity';
    }

    #[\Override]
    protected function getStub(): string
    {
        return $this->resolveStubPath();
    }

    protected function resolveStubPath(): string
    {
        $customPath = $this->getLaravel()->basePath('stubs/validity.stub');

        return \file_exists($customPath) ? $customPath : __DIR__ . '/validity.stub';
    }
}
