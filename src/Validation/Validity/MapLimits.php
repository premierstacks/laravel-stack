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

class MapLimits
{
    public function __construct(public MapValidity $validity) {}

    /**
     * @param array<array-key, string> $structure
     */
    public function exact(array $structure): MapValidity
    {
        return $this->validity->exact($structure);
    }

    /**
     * @param array<array-key, string> $structure
     */
    public function include(array $structure): MapValidity
    {
        return $this->validity->includes($structure);
    }

    /**
     * @param array<array-key, array-key> $keys
     */
    public function key(array $keys): MapValidity
    {
        return $this->validity->key($keys, true);
    }

    /**
     * @param array<array-key, array-key> $keys
     */
    public function keys(array $keys): MapValidity
    {
        return $this->validity->keys($keys, true);
    }

    public function unlimited(): MapValidity
    {
        return $this->validity;
    }
}
