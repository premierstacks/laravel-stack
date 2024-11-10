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

use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Validation\Rules\ValidationRule;
use Premierstacks\PhpStack\Encoding\Json;
use Premierstacks\PhpStack\Mixed\Filter;

class BboxRule extends ValidationRule
{
    /**
     * Create a new rule instance.
     *
     * {@inheritDoc}
     */
    public function __construct()
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

        $topLeft = Filter::nullableArray($value[0] ?? null, null);
        $bottomRight = Filter::nullableArray($value[1] ?? null, null);

        if ($topLeft === null || $bottomRight === null) {
            return false;
        }

        $lat0 = Filter::nullableFloat($topLeft['lat'] ?? $topLeft[0] ?? null, null);
        $lng0 = Filter::nullableFloat($topLeft['lng'] ?? $topLeft[1] ?? null, null);
        $lat1 = Filter::nullableFloat($bottomRight['lat'] ?? $bottomRight[0] ?? null, null);
        $lng1 = Filter::nullableFloat($bottomRight['lng'] ?? $bottomRight[1] ?? null, null);

        if ($lat0 === null || $lng0 === null || $lat1 === null || $lng1 === null) {
            return false;
        }

        return $lat0 > $lat1 && $lng0 < $lng1;
    }
}
