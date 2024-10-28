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

namespace Premierstacks\LaravelStack\Validation\Validity;

use Illuminate\Database\Schema\Builder as SchmeaBuilder;
use Premierstacks\PhpStack\Debug\Errorf;

class StringLimits
{
    public const int LONG_TEXT_MAX = 4_294_967_295;

    public const int MEDIUM_TEXT_MAX = 16_777_215;

    public const int TEXT_MAX = 65_535;

    public const int TINY_TEXT_MAX = 256;

    public const int VARCHAR_MAX = 65_535;

    public function __construct(public StringValidity $validity) {}

    public function between(int $min, int $max): StringValidity
    {
        return $this->validity->between($min, $max);
    }

    /**
     * @param class-string<\BackedEnum> $enum
     */
    public function enum(string $enum): StringValidity
    {
        return $this->validity->enum($enum);
    }

    /**
     * @param array<array-key, mixed> $enum
     */
    public function in(array $enum): StringValidity
    {
        return $this->validity->in($enum);
    }

    public function longText(int|null $max = null): StringValidity
    {
        $max ??= static::LONG_TEXT_MAX;

        if ($max > static::LONG_TEXT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, (string) static::LONG_TEXT_MAX));
        }

        return $this->max($max);
    }

    public function max(int $max): StringValidity
    {
        return $this->validity->max($max);
    }

    public function mediumText(int|null $max = null): StringValidity
    {
        $max ??= static::MEDIUM_TEXT_MAX;

        if ($max > static::MEDIUM_TEXT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, (string) static::MEDIUM_TEXT_MAX));
        }

        return $this->max($max);
    }

    public function size(int $size): StringValidity
    {
        return $this->validity->size($size);
    }

    public function text(int|null $max = null): StringValidity
    {
        $max ??= static::TEXT_MAX;

        if ($max > static::TEXT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, (string) static::TEXT_MAX));
        }

        return $this->max($max);
    }

    public function tinyText(int|null $max = null): StringValidity
    {
        $max ??= static::TINY_TEXT_MAX;

        if ($max > static::TINY_TEXT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, (string) static::TINY_TEXT_MAX));
        }

        return $this->max($max);
    }

    public function unlimited(): StringValidity
    {
        return $this->validity;
    }

    public function varchar(int|null $max = null): StringValidity
    {
        $max ??= SchmeaBuilder::$defaultStringLength ?? static::TINY_TEXT_MAX;

        if ($max > static::VARCHAR_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, (string) static::VARCHAR_MAX));
        }

        return $this->max($max);
    }
}
