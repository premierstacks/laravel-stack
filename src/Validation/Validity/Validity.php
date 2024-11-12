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

class Validity
{
    public static function boolean(): BooleanValidity
    {
        return new BooleanValidity();
    }

    public static function bytes(): StringLimits
    {
        return new StringLimits(new StringValidity());
    }

    public static function carbon(): CarbonLimits
    {
        return new CarbonLimits(new CarbonValidity());
    }

    public static function float(): FloatLimits
    {
        return new FloatLimits(new FloatValidity());
    }

    public static function integer(): IntegerLimits
    {
        return new IntegerLimits(new IntegerValidity());
    }

    public static function list(): ListLimits
    {
        return new ListLimits(new ListValidity());
    }

    public static function map(): MapLimits
    {
        return new MapLimits(new MapValidity());
    }

    public static function mixed(): MixedValidity
    {
        return new MixedValidity();
    }

    public static function resource(): FileLimits
    {
        return new FileLimits(new FileValidity());
    }

    public static function string(): StringLimits
    {
        return new StringLimits(new StringValidity());
    }
}
