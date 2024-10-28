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

namespace Premierstacks\LaravelStack\Validation\Rules;

use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;

class CallbackRule extends ValidationRule
{
    /**
     * @param \Closure(string, mixed, Validator, \Closure(string): PotentiallyTranslatedString $fail): (array<int, string>|array<string, array<array-key, mixed>>|bool|null) $callback
     */
    public function __construct(public \Closure $callback)
    {
        parent::__construct();
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        return ($this->callback)($attribute, $value, $validator, $fail);
    }
}
