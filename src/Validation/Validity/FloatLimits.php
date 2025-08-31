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

class FloatLimits
{
    public function __construct(public FloatValidity $validity) {}

    public function between(float $min, float $max): FloatValidity
    {
        return $this->validity->between($min, $max);
    }

    /**
     * @param array<array-key, mixed> $enum
     */
    public function in(array $enum): FloatValidity
    {
        return $this->validity->in($enum);
    }

    public function size(float $size): FloatValidity
    {
        return $this->validity->size($size);
    }

    public function unlimited(): FloatValidity
    {
        return $this->validity;
    }
}
