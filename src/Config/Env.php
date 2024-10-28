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

namespace Premierstacks\LaravelStack\Config;

use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Support\Env as IlluminateEnv;
use Illuminate\Support\Str;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\Debug\Errorf;
use Premierstacks\PhpStack\Enums\Undefined;
use Premierstacks\PhpStack\Mixed\Assert;

class Env
{
    use InjectTrait;

    public function __construct(public ApplicationContract $app)
    {
        if ($this->app->bound('env')) {
            throw new \RuntimeException('Env is already bound to the container.');
        }
    }

    public function get(string $key, mixed $default = Undefined::value): mixed
    {
        if ($default === Undefined::value) {
            $value = IlluminateEnv::getOrFail($key);
        } else {
            $value = IlluminateEnv::get($key, $default);
        }

        return $value;
    }

    public function getAppEnv(): string
    {
        return Assert::string($this->get('APP_ENV'));
    }

    /**
     * @param array<array-key, string> $envs
     */
    public function isAppEnv(array $envs): bool
    {
        return Str::is($envs, $this->getAppEnv());
    }

    /**
     * @template T
     *
     * @param array<string, T> $mapping
     *
     * @return T
     */
    public function mapAppEnv(array $mapping): mixed
    {
        return $mapping[$this->getAppEnv()] ?? throw new \OutOfRangeException(Errorf::invalidTargetKey($this->getAppEnv(), $mapping));
    }
}
