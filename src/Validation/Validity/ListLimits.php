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

namespace Premierstacks\LaravelStack\Validation\Validity;

class ListLimits
{
    public function __construct(public ListValidity $validity) {}

    public function between(int $min, int $max): ListValidity
    {
        return $this->validity->between($min, $max);
    }

    /**
     * @param array<array-key, array-key> $keys
     */
    public function key(array $keys): ListValidity
    {
        return $this->validity->key($keys, true);
    }

    /**
     * @param array<array-key, array-key> $keys
     */
    public function keys(array $keys): ListValidity
    {
        return $this->validity->keys($keys, true);
    }

    public function max(int $max): ListValidity
    {
        return $this->validity->max($max);
    }

    public function size(int $size): ListValidity
    {
        return $this->validity->size($size);
    }

    public function unlimited(): ListValidity
    {
        return $this->validity;
    }
}
