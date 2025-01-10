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
use Premierstacks\PhpStack\Debug\Errorf;

class Point implements Expression, Geom
{
    /**
     * @var array<string, array{float, float}>
     */
    public const array CITIES = [
        'Prague' => [50.073_658, 14.418_54],
    ];

    public function __construct(public float $lat, public float $lng, public int $srid = 4_326) {}

    #[\Override]
    public function getGeomFromText(): string
    {
        return "ST_GeomFromText('POINT({$this->getPoint()})',{$this->srid})";
    }

    public function getPoint(): string
    {
        return "{$this->lat} {$this->lng}";
    }

    #[\Override]
    public function getValue(Grammar $grammar): string
    {
        return $this->getGeomFromText();
    }

    /**
     * @param array{float, float}|array{lat: float, lng: float} $point
     */
    public static function createFromArray(array $point): self
    {
        $lat = $point['lat'] ?? $point[0] ?? throw new \InvalidArgumentException(Errorf::invalidArgument('point', $point, 'array{float, float}|array{lat: float, lng: float}'));
        $lng = $point['lng'] ?? $point[1] ?? throw new \InvalidArgumentException(Errorf::invalidArgument('point', $point, 'array{float, float}|array{lat: float, lng: float}'));

        return new self($lat, $lng);
    }
}
