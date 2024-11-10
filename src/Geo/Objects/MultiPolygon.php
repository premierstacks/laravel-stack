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

namespace Premierstacks\LaravelStack\Geo\Objects;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Grammar;

class MultiPolygon implements Expression, Geom
{
    /**
     * @param array<array-key, Polygon> $polygons
     */
    public function __construct(public array $polygons, public int $srid = 4_326) {}

    #[\Override]
    public function getGeomFromText(): string
    {
        $polygons = \implode(
            '), (',
            \array_map(static fn(Polygon $polygon): string => $polygon->getPolygon(), $this->polygons),
        );

        return "ST_GeomFromText('MULTIPOLYGON(({$polygons}))', {$this->srid})";
    }

    #[\Override]
    public function getValue(Grammar $grammar): string
    {
        return $this->getGeomFromText();
    }

    /**
     * @param array<array-key, array<array-key, array<array-key, array{float, float}|array{lat: float, lng: float}>>> $points
     */
    public static function createFromArray(array $points): self
    {
        return new self(
            \array_map(static function (array $points): Polygon {
                return new Polygon(
                    \array_map(static fn(array $points): array => \array_map(static fn(array $point): Point => Point::createFromArray($point), $points), $points),
                );
            }, $points),
        );
    }
}
