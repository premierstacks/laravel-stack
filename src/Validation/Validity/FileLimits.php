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
