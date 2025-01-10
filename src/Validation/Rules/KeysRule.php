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

class KeysRule extends ValidationRule
{
    /**
     * @param array<array-key, array-key> $keys
     */
    public function __construct(public array $keys, public bool $required)
    {
        parent::__construct();
    }

    #[\Override]
    public function fail(string $attribute, mixed $value, Validator $validator, \Closure $fail): void
    {
        $validator->addFailure($attribute, 'RequiredArrayKeys', $this->keys);
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        if (!\is_array($value)) {
            return false;
        }

        $occured = false;

        foreach ($value as $k => $v) {
            if (!\in_array($k, $this->keys, true)) {
                return false;
            }

            $occured = true;
        }

        return $occured || !$this->required;
    }
}
