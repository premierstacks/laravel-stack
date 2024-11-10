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

namespace Premierstacks\LaravelStack\Geo\Mysql;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Geo\Objects\Geom;
use Premierstacks\LaravelStack\Geo\Objects\Point;
use Premierstacks\PhpStack\Mixed\Filter;

class MysqlGeo
{
    public static function getGeomGeomContains(Geom $boundary, Geom $geom): bool
    {
        $connection = Resolver::databaseConnectionContract();

        $result = $connection->selectOne("select st_contains({$boundary->getGeomFromText()}, {$geom->getGeomFromText()}) as contains");

        if (!\is_object($result)) {
            return false;
        }

        if (!\property_exists($result, 'contains')) {
            return false;
        }

        return $result->contains === 1;
    }

    public static function getGeomGeomDistance(Geom $a, Geom $b): float
    {
        $connection = Resolver::databaseConnectionContract();

        $result = $connection->selectOne("select st_distance_sphere({$a->getGeomFromText()}, {$b->getGeomFromText()}) as distance");

        if (!\is_object($result)) {
            throw new \RuntimeException();
        }

        if (!\property_exists($result, 'distance')) {
            throw new \RuntimeException();
        }

        return Filter::float($result->distance);
    }

    /**
     * @param Builder<Model> $builder
     */
    public static function scopeGeomColumnContains(Builder $builder, Geom $geom, string $column): void
    {
        $builder->getQuery()->whereRaw("st_contains({$geom->getGeomFromText()}, {$builder->qualifyColumn($column)})");
    }

    /**
     * @param Builder<Model> $builder
     */
    public static function selectColumnGeomDistance(Builder $builder, string $column, Point $point, string|null $distance = null): void
    {
        $distance ??= $column . '_distance';

        $builder->getQuery()->selectRaw("st_distance_sphere({$builder->qualifyColumn($column)}, {$point->getGeomFromText()}) as {$distance}");
    }

    /**
     * @param Builder<Model> $builder
     */
    public static function selectLatLng(Builder $builder, string $column, string|null $lat = null, string|null $lng = null): void
    {
        $lat ??= $column . '_lat';
        $lng ??= $column . '_lng';

        $builder
            ->getQuery()
            ->selectRaw("st_latitude({$builder->qualifyColumn($column)}) as {$lat}")
            ->selectRaw("st_longitude({$builder->qualifyColumn($column)}) as {$lng}");
    }

    public static function validateGeom(Geom $geom): bool
    {
        $connection = Resolver::databaseConnectionContract();

        $result = $connection->selectOne("select st_isvalid({$geom->getGeomFromText()}) as is_valid");

        if (!\is_object($result)) {
            throw new \RuntimeException();
        }

        if (!\property_exists($result, 'is_valid')) {
            throw new \RuntimeException();
        }

        return $result->is_valid === 1;
    }
}