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

class IcoRule extends ValidationRule
{
    public function __construct()
    {
        parent::__construct();
    }

    #[\Override]
    public function fail(string $attribute, mixed $value, Validator $validator, \Closure $fail): void
    {
        $validator->addFailure($attribute, 'Regex');
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        if (!\is_string($value)) {
            return false;
        }

        if (\preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        return !(!$this->validateChecksum($value));
    }

    protected function validateChecksum(string $value): bool
    {
        $cheksum = 0;

        for ($i = 0; $i < 7; ++$i) {
            $cheksum += (int) $value[$i] * (8 - $i);
        }

        $cheksum %= 11;

        if ($cheksum === 0) {
            $controll = 1;
        } elseif ($cheksum === 1) {
            $controll = 0;
        } else {
            $controll = 11 - $cheksum;
        }

        return $controll === (int) $value[7];
    }
}
