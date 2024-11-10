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

namespace Premierstacks\LaravelStack\Geo\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes as CastsAttributesContract;
use Illuminate\Database\Eloquent\Model;
use Premierstacks\LaravelStack\Geo\Objects\Point;
use Premierstacks\PhpStack\Mixed\Filter;

/**
 * @implements CastsAttributesContract<mixed, mixed>
 */
class PointCast implements CastsAttributesContract
{
    /**
     * @param array<array-key, mixed> $attributes
     */
    #[\Override]
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof Point) {
            return $value;
        }

        if (\array_key_exists("{$key}_lat", $model->getAttributes()) && \array_key_exists("{$key}_lng", $model->getAttributes())) {
            $lat = Filter::nullableFloat($model->getAttribute("{$key}_lat"), null);
            $lng = Filter::nullableFloat($model->getAttribute("{$key}_lng"), null);

            if ($lat === null || $lng === null) {
                return $value;
            }

            return new Point($lat, $lng);
        }

        return $value;
    }

    /**
     * @param array<array-key, mixed> $attributes
     */
    #[\Override]
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!\is_array($value)) {
            return $value;
        }

        $lat = Filter::nullableFloat($value['lat'] ?? $value[0] ?? null, null);
        $lng = Filter::nullableFloat($value['lng'] ?? $value[1] ?? null, null);

        if ($lat === null || $lng === null) {
            return $value;
        }

        return new Point($lat, $lng);
    }
}
