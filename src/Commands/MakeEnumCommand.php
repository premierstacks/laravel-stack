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

use Illuminate\Console\GeneratorCommand;

class MakeEnumCommand extends GeneratorCommand
{
    protected $description = 'Create a new custom Enum class';

    protected $name = 'psls:make:enum';

    protected $type = 'Enum';

    #[\Override]
    protected function getDefaultNamespace(mixed $rootNamespace): string
    {
        return parent::getDefaultNamespace($rootNamespace) . '\Enums';
    }

    #[\Override]
    protected function getStub(): string
    {
        return $this->resolveStubPath();
    }

    protected function resolveStubPath(): string
    {
        $customPath = $this->getLaravel()->basePath('stubs/enum.stub');

        return \file_exists($customPath) ? $customPath : __DIR__ . '/stubs/enum.stub';
    }
}
