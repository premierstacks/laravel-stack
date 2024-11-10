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

namespace Premierstacks\LaravelStack\Geo\Rules;

use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Geo\Objects\Point;
use Premierstacks\PhpStack\Encoding\Json;
use Premierstacks\PhpStack\Mixed\Filter;

class PointRule extends \Premierstacks\LaravelStack\Validation\Rules\ValidationRule
{
    /**
     * @param (\Closure(Point, string, mixed, Validator, \Closure(string): PotentiallyTranslatedString): bool|null)|null $validate
     */
    public function __construct(public \Closure|null $validate = null)
    {
        parent::__construct();
    }

    #[\Override]
    public function fail(string $attribute, mixed $value, Validator $validator, \Closure $fail): void
    {
        $validator->addFailure($attribute, 'Invalid');
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        if (\is_string($value) && \json_validate($value)) {
            $value = Json::decode($value, true);
        }

        if (!\is_array($value)) {
            return false;
        }

        $lat = Filter::nullableFloat($value['lat'] ?? $value[0] ?? null, null);
        $lng = Filter::nullableFloat($value['lng'] ?? $value[1] ?? null, null);

        if ($lat === null || $lng === null) {
            return false;
        }

        if ($lat < -90 || $lat > 90 || $lng < -180 || $lng >= 180) {
            return false;
        }

        if ($this->validate !== null) {
            return ($this->validate)(new Point($lat, $lng), $attribute, $validator, $validator, $fail);
        }

        return true;
    }
}
