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
    public static array $bankCodes = [
        '0100',
        '0300',
        '0600',
        '0710',
        '0800',
        '2010',
        '2020',
        '2060',
        '2070',
        '2100',
        '2200',
        '2220',
        '2250',
        '2260',
        '2275',
        '2600',
        '2700',
        '3030',
        '3050',
        '3060',
        '3500',
        '4000',
        '4300',
        '5500',
        '5800',
        '6000',
        '6100',
        '6200',
        '6210',
        '6300',
        '6700',
        '6800',
        '7910',
        '7950',
        '7960',
        '7970',
        '7990',
        '8030',
        '8040',
        '8060',
        '8090',
        '8150',
        '8190',
        '8198',
        '8199',
        '8200',
        '8220',
        '8230',
        '8240',
        '8250',
        '8255',
        '8265',
        '8270',
        '8280',
        '8293',
        '8299',
        '8500',
    ];

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

        if (Conf::inject()->isAppEnv(['testing'])) {
            return true;
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

        return !(!\in_array($parts[4], static::$bankCodes, true));
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