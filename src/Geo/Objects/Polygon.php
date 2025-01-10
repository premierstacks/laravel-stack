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
            \array_map(static fn(array $ring): string => \implode(
                ', ',
                \array_map(static fn(Point $point): string => $point->getPoint(), $ring),
            ), $this->rings),
        );

        return "({$rings})";
    }

    #[\Override]
    public function getValue(Grammar $grammar): string
    {
        return $this->getGeomFromText();
    }
}
