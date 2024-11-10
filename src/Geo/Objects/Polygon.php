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

class Polygon implements Expression, Geom
{
    /**
     * @param array<array-key, array<array-key, Point>> $rings
     */
    public function __construct(public array $rings, public int $srid = 4_326)
    {
        foreach ($this->rings as $key => $ring) {
            if (isset($ring[0]) && $ring[0] !== \end($ring)) {
                $this->rings[$key][] = $ring[0];
            }
        }
    }

    #[\Override]
    public function getGeomFromText(): string
    {
        return "ST_GeomFromText('POLYGON({$this->getPolygon()})', {$this->srid})";
    }

    public function getPolygon(): string
    {
        $rings = \implode(
            '), (',
            \array_map(static function (array $ring): string {
                return \implode(
                    ', ',
                    \array_map(static fn(Point $point): string => $point->getPoint(), $ring),
                );
            }, $this->rings),
        );

        return "({$rings})";
    }

    #[\Override]
    public function getValue(Grammar $grammar): string
    {
        return $this->getGeomFromText();
    }
}
