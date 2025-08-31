<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Validation\Validity;

use Premierstacks\PhpStack\Debug\Errorf;

class IntegerLimits
{
    public const int BIG_INT_MAX = \PHP_INT_MAX;

    public const int BIG_INT_MIN = \PHP_INT_MIN;

    public const int INT_MAX = 2_147_483_647;

    public const int INT_MIN = -2_147_483_648;

    public const int MEDIUM_INT_MAX = 8_388_607;

    public const int MEDIUM_INT_MIN = -8_388_608;

    public const int SMALL_INT_MAX = 32_767;

    public const int SMALL_INT_MIN = -32_768;

    public const int TINY_INT_MAX = 127;

    public const int TINY_INT_MIN = -128;

    public const int UNSIGNED_BIG_INT_MAX = \PHP_INT_MAX;

    public const int UNSIGNED_BIG_INT_MIN = 0;

    public const int UNSIGNED_INT_MAX = 4_294_967_295;

    public const int UNSIGNED_INT_MIN = 0;

    public const int UNSIGNED_MEDIUM_INT_MAX = 16_777_215;

    public const int UNSIGNED_MEDIUM_INT_MIN = 0;

    public const int UNSIGNED_SMALL_INT_MAX = 65_535;

    public const int UNSIGNED_SMALL_INT_MIN = 0;

    public const int UNSIGNED_TINY_INT_MAX = 255;

    public const int UNSIGNED_TINY_INT_MIN = 0;

    public function __construct(public IntegerValidity $validity) {}

    public function between(int $min, int $max): IntegerValidity
    {
        return $this->validity->between($min, $max);
    }

    public function bigInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::BIG_INT_MIN;
        $max ??= static::BIG_INT_MAX;

        if ($min < static::BIG_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'big int'));
        }

        return $this->between($min, $max);
    }

    /**
     * @param class-string<\BackedEnum> $enum
     */
    public function enum(string $enum): IntegerValidity
    {
        return $this->validity->enum($enum);
    }

    /**
     * @param array<array-key, mixed> $enum
     */
    public function in(array $enum): IntegerValidity
    {
        return $this->validity->in($enum);
    }

    public function int(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::INT_MIN;
        $max ??= static::INT_MAX;

        if ($min < static::INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'int'));
        }

        if ($max > static::INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'int'));
        }

        return $this->between($min, $max);
    }

    public function mediumInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::MEDIUM_INT_MIN;
        $max ??= static::MEDIUM_INT_MAX;

        if ($min < static::MEDIUM_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'medium int'));
        }

        if ($max > static::MEDIUM_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'medium int'));
        }

        return $this->between($min, $max);
    }

    public function positive(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= 1;
        $max ??= static::UNSIGNED_BIG_INT_MAX;

        if ($min < 1) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, '1'));
        }

        if ($max > static::UNSIGNED_BIG_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'unsigned big int'));
        }

        return $this->between($min, $max);
    }

    public function size(int $size): IntegerValidity
    {
        return $this->validity->size($size);
    }

    public function smallInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::SMALL_INT_MIN;
        $max ??= static::SMALL_INT_MAX;

        if ($min < static::SMALL_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'small int'));
        }

        if ($max > static::SMALL_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'small int'));
        }

        return $this->between($min, $max);
    }

    public function tinyInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::TINY_INT_MIN;
        $max ??= static::TINY_INT_MAX;

        if ($min < static::TINY_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'tiny int'));
        }

        if ($max > static::TINY_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'tiny int'));
        }

        return $this->between($min, $max);
    }

    public function unlimited(): IntegerValidity
    {
        return $this->validity;
    }

    public function unsignedBigInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::UNSIGNED_BIG_INT_MIN;
        $max ??= static::UNSIGNED_BIG_INT_MAX;

        if ($min < static::UNSIGNED_BIG_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'unsigned big int'));
        }

        return $this->between($min, $max);
    }

    public function unsignedInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::UNSIGNED_INT_MIN;
        $max ??= static::UNSIGNED_INT_MAX;

        if ($min < static::UNSIGNED_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'unsigned int'));
        }

        if ($max > static::UNSIGNED_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'unsigned int'));
        }

        return $this->between($min, $max);
    }

    public function unsignedMediumInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::UNSIGNED_MEDIUM_INT_MIN;
        $max ??= static::UNSIGNED_MEDIUM_INT_MAX;

        if ($min < static::UNSIGNED_MEDIUM_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'unsigned medium int'));
        }

        if ($max > static::UNSIGNED_MEDIUM_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'unsigned medium int'));
        }

        return $this->between($min, $max);
    }

    public function unsignedSmallInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::UNSIGNED_SMALL_INT_MIN;
        $max ??= static::UNSIGNED_SMALL_INT_MAX;

        if ($min < static::UNSIGNED_SMALL_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'unsigned small int'));
        }

        if ($max > static::UNSIGNED_SMALL_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'unsigned small int'));
        }

        return $this->between($min, $max);
    }

    public function unsignedTinyInt(int|null $max = null, int|null $min = null): IntegerValidity
    {
        $min ??= static::UNSIGNED_TINY_INT_MIN;
        $max ??= static::UNSIGNED_TINY_INT_MAX;

        if ($min < static::UNSIGNED_TINY_INT_MIN) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('min', $min, 'unsigned tiny int'));
        }

        if ($max > static::UNSIGNED_TINY_INT_MAX) {
            throw new \InvalidArgumentException(Errorf::invalidArgument('max', $max, 'unsigned tiny int'));
        }

        return $this->between($min, $max);
    }
}
