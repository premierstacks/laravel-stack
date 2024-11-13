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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Premierstacks\LaravelStack\Validation\Rules\CallbackRule;
use Premierstacks\PhpStack\Mixed\Assert;

trait ScalarValidityTrait
{
    /**
     * @return $this
     */
    public function confirmed(): static
    {
        return $this->add('confirmed');
    }

    /**
     * @param array<array-key, string> $wheres
     *
     * @return $this
     */
    public function exists(string $table, string $column, array $wheres = []): static
    {
        return $this->add('exists', [$table, $column, ...$wheres]);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function in(array $values): static
    {
        $this->in = $values;

        return $this;
    }

    /**
     * @return $this
     */
    public function inArray(string $field): static
    {
        return $this->add('in_array', [$field]);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function notIn(array $values): static
    {
        $this->notIn = $values;

        return $this;
    }

    /**
     * @template T of Builder
     *
     * @param \Closure(): T $callback
     * @param \Closure(mixed, mixed): bool|null $each
     *
     * @return $this
     */
    public function notPluck(\Closure $callback, string $column, \Closure|null $each = null): static
    {
        $keys = null;

        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each, $column, &$keys): bool {
                if ($keys === null) {
                    $builder = $callback();

                    $keys = $builder
                        ->getQuery()
                        ->distinct()
                        ->pluck($builder->qualifyColumn($column));
                }

                if (!$keys->contains($value)) {
                    return true;
                }

                if ($each === null) {
                    return false;
                }

                return $each($value, $attribute);
            }),
        );
    }

    /**
     * @template T of Builder
     *
     * @param \Closure(): T $callback
     * @param \Closure(mixed, mixed): bool|null $each
     *
     * @return $this
     */
    public function notPluckKey(\Closure $callback, \Closure|null $each = null): static
    {
        $keys = null;

        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each, &$keys): bool {
                if ($keys === null) {
                    $builder = $callback();

                    $keys = $builder
                        ->getQuery()
                        ->distinct()
                        ->pluck($builder->qualifyColumn(Assert::instance($builder->getModel(), Model::class)->getKeyName()));
                }

                if (!$keys->contains($value)) {
                    return true;
                }

                if ($each === null) {
                    return false;
                }

                return $each($value, $attribute);
            }),
        );
    }

    /**
     * @template T of Builder
     *
     * @param \Closure(): T $callback
     * @param \Closure(mixed, mixed): bool|null $each
     *
     * @return $this
     */
    public function notPluckRouteKey(\Closure $callback, \Closure|null $each = null): static
    {
        $keys = null;

        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each, &$keys): bool {
                if ($keys === null) {
                    $builder = $callback();

                    $keys = $builder
                        ->getQuery()
                        ->distinct()
                        ->pluck($builder->qualifyColumn(Assert::instance($builder->getModel(), Model::class)->getRouteKeyName()));
                }

                if (!$keys->contains($value)) {
                    return true;
                }

                if ($each === null) {
                    return false;
                }

                return $each($value, $attribute);
            }),
        );
    }

    /**
     * @template TT of Model
     * @template T of Builder<TT>
     *
     * @param \Closure(mixed, string): T $callback
     * @param \Closure(T, mixed, string): bool|null $each
     *
     * @return $this
     */
    public function notRetrieveByKey(\Closure $callback, \Closure|null $each = null): static
    {
        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each): bool {
                $builder = $callback($value, $attribute);

                $builder->whereKey($value);

                $exists = $builder->toBase()->exists();

                if (!$exists) {
                    return true;
                }

                if ($each === null) {
                    return false;
                }

                return $each($builder, $value, $attribute);
            }),
        );
    }

    /**
     * @template TT of Model
     * @template T of Builder<TT>
     *
     * @param \Closure(mixed, string): T $callback
     * @param \Closure(T, mixed, string): bool|null $each
     *
     * @return $this
     */
    public function notRetrieveByRouteKey(\Closure $callback, \Closure|null $each = null): static
    {
        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each): bool {
                $builder = $callback($value, $attribute);

                $builder->where($builder->qualifyColumn(Assert::instance($builder->getModel(), Model::class)->getRouteKeyName()), '=', $value);

                $exists = $builder->toBase()->exists();

                if (!$exists) {
                    return true;
                }

                if ($each === null) {
                    return false;
                }

                return $each($builder, $value, $attribute);
            }),
        );
    }

    /**
     * @template TT of Model
     * @template T of Builder<TT>
     *
     * @param \Closure(mixed, string): T $callback
     * @param \Closure(T, mixed, string): bool|null $each
     *
     * @return $this
     */
    public function notRetrieveByScope(\Closure $callback, \Closure|null $each = null): static
    {
        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each): bool {
                $builder = $callback($value, $attribute);

                $exists = $builder->toBase()->exists();

                if (!$exists) {
                    return true;
                }

                if ($each === null) {
                    return false;
                }

                return $each($builder, $value, $attribute);
            }),
        );
    }

    /**
     * @template T of Builder
     *
     * @param \Closure(): T $callback
     * @param \Closure(mixed, mixed): bool|null $each
     *
     * @return $this
     */
    public function pluck(\Closure $callback, string $column, \Closure|null $each = null): static
    {
        $keys = null;

        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each, $column, &$keys): bool {
                if ($keys === null) {
                    $builder = $callback();

                    $keys = $builder
                        ->getQuery()
                        ->distinct()
                        ->pluck($builder->qualifyColumn($column));
                }

                if (!$keys->contains($value)) {
                    return false;
                }

                if ($each === null) {
                    return true;
                }

                return $each($value, $attribute);
            }),
        );
    }

    /**
     * @template T of Builder
     *
     * @param \Closure(): T $callback
     * @param \Closure(mixed, mixed): bool|null $each
     *
     * @return $this
     */
    public function pluckKey(\Closure $callback, \Closure|null $each = null): static
    {
        $keys = null;

        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each, &$keys): bool {
                if ($keys === null) {
                    $builder = $callback();

                    $keys = $builder
                        ->getQuery()
                        ->distinct()
                        ->pluck($builder->qualifyColumn(Assert::instance($builder->getModel(), Model::class)->getKeyName()));
                }

                if (!$keys->contains($value)) {
                    return false;
                }

                if ($each === null) {
                    return true;
                }

                return $each($value, $attribute);
            }),
        );
    }

    /**
     * @template T of Builder
     *
     * @param \Closure(): T $callback
     * @param \Closure(mixed, mixed): bool|null $each
     *
     * @return $this
     */
    public function pluckRouteKey(\Closure $callback, \Closure|null $each = null): static
    {
        $keys = null;

        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each, &$keys): bool {
                if ($keys === null) {
                    $builder = $callback();

                    $keys = $builder
                        ->getQuery()
                        ->distinct()
                        ->pluck($builder->qualifyColumn(Assert::instance($builder->getModel(), Model::class)->getRouteKeyName()));
                }

                if (!$keys->contains($value)) {
                    return false;
                }

                if ($each === null) {
                    return true;
                }

                return $each($value, $attribute);
            }),
        );
    }

    /**
     * @template TT of Model
     * @template T of Builder<TT>
     *
     * @param \Closure(mixed, string): T $callback
     * @param \Closure(T, mixed, string): bool|null $each
     *
     * @return $this
     */
    public function retrieveByKey(\Closure $callback, \Closure|null $each = null): static
    {
        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each): bool {
                $builder = $callback($value, $attribute);

                $builder->whereKey($value);

                $exists = $builder->toBase()->exists();

                if (!$exists) {
                    return false;
                }

                if ($each === null) {
                    return true;
                }

                return $each($builder, $value, $attribute);
            }),
        );
    }

    /**
     * @template TT of Model
     * @template T of Builder<TT>
     *
     * @param \Closure(mixed, string): T $callback
     * @param \Closure(T, mixed, string): bool|null $each
     *
     * @return $this
     */
    public function retrieveByRouteKey(\Closure $callback, \Closure|null $each = null): static
    {
        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each): bool {
                $builder = $callback($value, $attribute);

                $builder->where($builder->qualifyColumn(Assert::instance($builder->getModel(), Model::class)->getRouteKeyName()), '=', $value);

                $exists = $builder->toBase()->exists();

                if (!$exists) {
                    return false;
                }

                if ($each === null) {
                    return true;
                }

                return $each($builder, $value, $attribute);
            }),
        );
    }

    /**
     * @template TT of Model
     * @template T of Builder<TT>
     *
     * @param \Closure(mixed, string): T $callback
     * @param \Closure(T, mixed, string): bool|null $each
     *
     * @return $this
     */
    public function retrieveByScope(\Closure $callback, \Closure|null $each = null): static
    {
        return $this->add(
            new CallbackRule(static function (string $attribute, mixed $value) use ($callback, $each): bool {
                $builder = $callback($value, $attribute);

                $exists = $builder->toBase()->exists();

                if (!$exists) {
                    return false;
                }

                if ($each === null) {
                    return true;
                }

                return $each($builder, $value, $attribute);
            }),
        );
    }

    /**
     * @return $this
     */
    public function same(string $field): static
    {
        return $this->add('same', [$field]);
    }

    /**
     * @param array<array-key, string> $wheres
     *
     * @return $this
     */
    public function unique(string $table, string $column, int|string|null $id = null, string|null $idColumn = null, array $wheres = []): static
    {
        return $this->add('unique', [$table, $column, $id, $idColumn, ...$wheres]);
    }
}
