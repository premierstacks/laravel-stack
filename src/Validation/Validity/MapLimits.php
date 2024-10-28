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

class MapLimits
{
    public function __construct(public Mapvalidity $validity) {}

    /**
     * @param array<array-key, string> $structure
     */
    public function exact(array $structure): Mapvalidity
    {
        return $this->validity->exact($structure);
    }

    /**
     * @param array<array-key, string> $structure
     */
    public function include(array $structure): Mapvalidity
    {
        return $this->validity->includes($structure);
    }

    /**
     * @param array<array-key, array-key> $keys
     */
    public function key(array $keys): Mapvalidity
    {
        return $this->validity->key($keys, true);
    }

    /**
     * @param array<array-key, array-key> $keys
     */
    public function keys(array $keys): Mapvalidity
    {
        return $this->validity->keys($keys, true);
    }

    public function unlimited(): Mapvalidity
    {
        return $this->validity;
    }
}
