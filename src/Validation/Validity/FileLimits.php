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

class FileLimits
{
    public function __construct(public FileValidity $validity) {}

    public function between(int $min, int $max): FileType
    {
        return new FileType($this->validity->between($min, $max));
    }

    public function max(int $max): FileType
    {
        return new FileType($this->validity->max($max));
    }

    public function size(int $size): FileType
    {
        return new FileType($this->validity->size($size));
    }

    public function unlimited(): FileType
    {
        return new FileType($this->validity);
    }
}
