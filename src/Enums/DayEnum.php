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

namespace Premierstacks\LaravelStack\Enums;

enum DayEnum: int
{
    case Friday = 16;

    case Monday = 1;

    case Saturday = 32;

    case Sunday = 64;

    case Thursday = 8;

    case Tuesday = 2;

    case Wednesday = 4;

    public static function createFromIso(int $dayOfWeek): self
    {
        return match ($dayOfWeek) {
            1 => self::Monday,
            2 => self::Tuesday,
            3 => self::Wednesday,
            4 => self::Thursday,
            5 => self::Friday,
            6 => self::Saturday,
            7 => self::Sunday,
            default => throw new \InvalidArgumentException(),
        };
    }

    /**
     * @return array<int, int>
     */
    public static function values(): array
    {
        return \array_column(self::cases(), 'value');
    }
}
