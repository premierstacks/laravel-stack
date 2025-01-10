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

namespace Premierstacks\LaravelStack\Validation\Rules;

use Illuminate\Validation\Validator;
use Premierstacks\PhpStack\Mixed\Assert;

class ValidateRule extends ValidationRule
{
    /**
     * @param \Closure(string, mixed): array<array-key, mixed> $rules
     */
    public function __construct(public \Closure $rules)
    {
        parent::__construct();
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        $rules = ($this->rules)($attribute, $value);

        $clone = clone $validator;

        $passes = $clone->setRules($rules)->passes();

        if ($passes) {
            return true;
        }

        foreach ($clone->errors()->messages() as $k => $v) {
            $validator->messages()->add((string) $k, Assert::nonEmptyString($v));
        }

        foreach ($clone->failed() as $k => $v) {
            $validator->addFailure($attribute, (string) $k, Assert::array($v));
        }

        return null;
    }
}
