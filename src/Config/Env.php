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
