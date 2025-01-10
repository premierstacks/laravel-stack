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
use Premierstacks\LaravelStack\Enums\CzPostCodeEnum;

class CzBankAccountNumberRule extends ValidationRule
{
    /**
     * @var array{0: int, 1: int, 2: int, 3: int, 4: int, 5: int, 6: int, 7: int, 8: int, 9: int}
     */
    public const array BASE_WEIGHTS = [6, 3, 7, 9, 10, 5, 8, 4, 2, 1];

    /**
     * @var array{0: int, 1: int, 2: int, 3: int, 4: int, 5: int}
     */
    public const array PREFIX_WEIGHTS = [10, 5, 8, 4, 2, 1];

    /**
     * @var array<array-key, string>
     */
    public static array $bankCodes = [];

    /**
     * Create a new rule instance.
     *
     * {@inheritDoc}
     */
    public function __construct(protected bool $validateBankCode = true)
    {
        parent::__construct();
    }

    #[\Override]
    public function fail(string $attribute, mixed $value, Validator $validator, \Closure $fail): void
    {
        $validator->addFailure($attribute, 'Regex', [$this->validateBankCode]);
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        if (!\is_string($value)) {
            return false;
        }

        if (\preg_match('/^(([0-9]{0,6})-)?([0-9]{2,10})\/([0-9]{4})$/', $value, $parts) !== 1) {
            return false;
        }

        if (!$this->validatePrefix($parts)) {
            return false;
        }

        if (!$this->validateBase($parts)) {
            return false;
        }

        if (!$this->validateBankCode) {
            return true;
        }

        return !(!\in_array($parts[4], static::$bankCodes === [] ? CzPostCodeEnum::values() : static::$bankCodes, true));
    }

    /**
     * @param array<array-key, string> $parts
     */
    protected function validateBase(array $parts): bool
    {
        $base = \mb_str_pad($parts[3] ?? '', 10, '0', \STR_PAD_LEFT);

        $sum = 0;

        for ($i = 0; $i < 10; ++$i) {
            $sum += (int) ($base[$i] ?? 0) * static::BASE_WEIGHTS[$i];
        }

        return !($sum % 11 !== 0);
    }

    /**
     * @param array<array-key, string> $parts
     */
    protected function validatePrefix(array $parts): bool
    {
        if (($parts[2] ?? '') === '') {
            return true;
        }

        $prefix = \mb_str_pad($parts[2] ?? '', 6, '0', \STR_PAD_LEFT);

        $sum = 0;

        for ($i = 0; $i < 6; ++$i) {
            $sum += (int) ($prefix[$i] ?? 0) * static::PREFIX_WEIGHTS[$i];
        }

        return !($sum % 11 !== 0);
    }
}
