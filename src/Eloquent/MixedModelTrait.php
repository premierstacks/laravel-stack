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

namespace Premierstacks\LaravelStack\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MissingAttributeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\LazyLoadingViolationException;
use Illuminate\Support\Carbon;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\Mixed\Assert;

trait MixedModelTrait
{
    use InjectTrait;

    public function attributeLoaded(string $key): bool
    {
        return \array_key_exists($key, $this->attributes);
    }

    public function getCreatedAt(): Carbon|null
    {
        return Assert::nullableInstance($this->getAttribute('created_at'), Carbon::class);
    }

    #[\Override]
    public function getKey(): int|string
    {
        return Assert::arrayKey(parent::getKey());
    }

    public function getQualifiedRouteKeyName(): string
    {
        return $this->qualifyColumn($this->getRouteKeyName());
    }

    #[\Override]
    public function getRouteKey(): string
    {
        return (string) Assert::arrayKey(parent::getRouteKey());
    }

    public function getUpdatedAt(): Carbon|null
    {
        return Assert::nullableInstance($this->getAttribute('updated_at'), Carbon::class);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function mustRetrieveByKey(int|string $key, \Closure|null $scope = null): static
    {
        $instance = $this->retrieveByKey($key, $scope);

        if ($instance !== null) {
            return $instance;
        }

        throw (new ModelNotFoundException())->setModel(static::class, [$key]);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function mustRetrieveByKeyOrRouteKey(int|string|null $key = null, string|null $routeKey = null, \Closure|null $scope = null): static
    {
        $instance = $this->retrieveByKeyOrRouteKey($key, $routeKey, $scope);

        if ($instance !== null) {
            return $instance;
        }

        $ids = [];

        if ($key !== null) {
            $ids[] = $key;
        }

        if ($routeKey !== null) {
            $ids[] = $routeKey;
        }

        throw (new ModelNotFoundException())->setModel(static::class, $ids);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function mustRetrieveByRouteKey(string $key, \Closure|null $scope = null): static
    {
        $instance = $this->retrieveByRouteKey($key, $scope);

        if ($instance !== null) {
            return $instance;
        }

        throw (new ModelNotFoundException())->setModel(static::class, [$key]);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function mustRetrieveByRouteKeyXorKey(int|string|null $key = null, string|null $routeKey = null, \Closure|null $scope = null): static
    {
        $instance = $this->retrieveByRouteKeyXorKey($key, $routeKey, $scope);

        if ($instance !== null) {
            return $instance;
        }

        $ids = [];

        if ($key !== null) {
            $ids[] = $key;
        }

        if ($routeKey !== null) {
            $ids[] = $routeKey;
        }

        throw (new ModelNotFoundException())->setModel(static::class, $ids);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function retrieveByKey(int|string $key, \Closure|null $scope = null): static|null
    {
        $builder = $this->newQuery()->whereKey($key);

        $scope?->__invoke($builder);

        return Assert::nullableInstance($builder->first(), static::class);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function retrieveByKeyOrRouteKey(int|string|null $key = null, string|null $routeKey = null, \Closure|null $scope = null): static|null
    {
        $builder = $this->newQuery();

        $builder->where(function (Builder $builder) use ($key, $routeKey): void {
            $builder
                ->where(function (Builder $builder) use ($key): void {
                    $this->scopeKey($builder, [$key]);
                })
                ->orWhere(function (Builder $builder) use ($routeKey): void {
                    $this->scopeRouteKey($builder, [$routeKey]);
                });
        });

        $scope?->__invoke($builder);

        return Assert::nullableInstance($builder->first(), static::class);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function retrieveByKeyXorRouteKey(int|string|null $key = null, string|null $routeKey = null, \Closure|null $scope = null): static|null
    {
        if ($key !== null) {
            return $this->retrieveByKey($key, $scope);
        }

        if ($routeKey !== null) {
            return $this->retrieveByRouteKey($routeKey, $scope);
        }

        return null;
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function retrieveByRouteKey(string $key, \Closure|null $scope = null): static|null
    {
        $builder = $this->newQuery();

        $builder->getQuery()->where($this->getQualifiedRouteKeyName(), '=', $key);

        $scope?->__invoke($builder);

        return Assert::nullableInstance($builder->first(), static::class);
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function retrieveByRouteKeyXorKey(int|string|null $key = null, string|null $routeKey = null, \Closure|null $scope = null): static|null
    {
        if ($routeKey !== null) {
            return $this->retrieveByRouteKey($routeKey, $scope);
        }

        if ($key !== null) {
            return $this->retrieveByKey($key, $scope);
        }

        return null;
    }

    /**
     * @template T of Model
     *
     * @param \Closure(Builder<T>): void|null $scope
     */
    public function retrieveFindByKeyXorRouteKey(int|string|null $key = null, string|null $routeKey = null, \Closure|null $scope = null): static
    {
        $instance = $this->retrieveByKeyXorRouteKey($key, $routeKey, $scope);

        if ($instance !== null) {
            return $instance;
        }

        $ids = [];

        if ($key !== null) {
            $ids[] = $key;
        }

        if ($routeKey !== null) {
            $ids[] = $routeKey;
        }

        throw (new ModelNotFoundException())->setModel(static::class, $ids);
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function scopeIn(Builder $builder, string $column, array $values): static
    {
        $builder->getQuery()->whereIn($builder->qualifyColumn($column), $values);

        return $this;
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function scopeKey(Builder $builder, array $values): static
    {
        $builder->whereKey($values);

        return $this;
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function scopeNotIn(Builder $builder, string $column, array $values): static
    {
        $builder->getQuery()->whereNotIn($builder->qualifyColumn($column), $values);

        return $this;
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function scopeNotKey(Builder $builder, array $values): static
    {
        $builder->whereKeyNot($values);

        return $this;
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function scopeNotRouteKey(Builder $builder, array $values): static
    {
        $builder->getQuery()->whereNotIn($this->getQualifiedRouteKeyName(), $values);

        return $this;
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function scopeRouteKey(Builder $builder, array $values): static
    {
        $builder->getQuery()->whereIn($this->getQualifiedRouteKeyName(), $values);

        return $this;
    }

    #[\Override]
    protected function asDateTime(mixed $value): Carbon
    {
        return parent::asDateTime($value)->setTimezone($this->freshTimestamp()->getTimezone());
    }

    #[\Override]
    protected function handleLazyLoadingViolation(mixed $key): never
    {
        throw new LazyLoadingViolationException($this, $key);
    }

    #[\Override]
    protected function throwMissingAttributeExceptionIfApplicable(mixed $key): never
    {
        throw new MissingAttributeException($this, $key);
    }
}
