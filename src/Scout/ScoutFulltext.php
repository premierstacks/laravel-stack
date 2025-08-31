<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Scout;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder as ScoutBuilder;

class ScoutFulltext
{
    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param ScoutBuilder<T> $scoutBuilder
     */
    public static function exact(Builder $builder, ScoutBuilder $scoutBuilder, int $take = \PHP_INT_MAX, bool $sort = true): void
    {
        static::perform($builder, static::exactKeys($scoutBuilder, $take), $sort);
    }

    /**
     * @template T of Model
     *
     * @param ScoutBuilder<T> $scoutBuilder
     *
     * @return Collection<array-key, mixed>
     */
    public static function exactKeys(ScoutBuilder $scoutBuilder, int $take = \PHP_INT_MAX): Collection
    {
        $scoutBuilder->query = "\"{$scoutBuilder->query}\"";

        return $scoutBuilder->take($take)->keys();
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param ScoutBuilder<T> $scoutBuilder
     */
    public static function exactPartial(Builder $builder, ScoutBuilder $scoutBuilder, int $take = \PHP_INT_MAX, bool $sort = true): void
    {
        static::perform($builder, static::exactPartialKeys($scoutBuilder, $take), $sort);
    }

    /**
     * @template T of Model
     *
     * @param ScoutBuilder<T> $scoutBuilder
     *
     * @return Collection<array-key, mixed>
     */
    public static function exactPartialKeys(ScoutBuilder $scoutBuilder, int $take = \PHP_INT_MAX): Collection
    {
        $partial = $scoutBuilder->query;

        $scoutBuilder->query = "\"{$scoutBuilder->query}\"";

        $keys = $scoutBuilder->take($take)->keys();

        if ($keys->isNotEmpty()) {
            return $keys;
        }

        $scoutBuilder->query = $partial;

        return $scoutBuilder->take($take)->keys();
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param ScoutBuilder<T> $scoutBuilder
     */
    public static function partial(Builder $builder, ScoutBuilder $scoutBuilder, int $take = \PHP_INT_MAX, bool $sort = true): void
    {
        static::perform($builder, static::partialKeys($scoutBuilder, $take), $sort);
    }

    /**
     * @template T of Model
     *
     * @param ScoutBuilder<T> $scoutBuilder
     *
     * @return Collection<array-key, mixed>
     */
    public static function partialKeys(ScoutBuilder $scoutBuilder, int $take = \PHP_INT_MAX): Collection
    {
        return $scoutBuilder->take($take)->keys();
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param Collection<array-key, mixed> $keys
     */
    protected static function perform(Builder $builder, Collection $keys, bool $sort = true): void
    {
        if ($keys->isEmpty()) {
            $builder->getQuery()->whereRaw('0 = 1');
        } else {
            $builder->whereKey($keys);

            if ($sort) {
                $builder->getQuery()->orderByRaw("field({$builder->getModel()->getQualifiedKeyName()},{$keys->implode(',')})");
            }
        }
    }
}
