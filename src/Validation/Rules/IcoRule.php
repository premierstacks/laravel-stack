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

use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Config\Conf;

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

        if (Conf::inject()->isAppEnv(['testing'])) {
            return true;
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
