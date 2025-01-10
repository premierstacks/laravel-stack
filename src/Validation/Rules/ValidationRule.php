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

use Illuminate\Contracts\Validation\ValidationRule as IlluminateValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;
use Premierstacks\PhpStack\Mixed\Assert;

abstract class ValidationRule implements IlluminateValidationRule, ValidatorAwareRule
{
    public bool $implicit = false;

    public Validator|null $validator = null;

    public function __construct() {}

    /**
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function fail(string $attribute, mixed $value, Validator $validator, \Closure $fail): void
    {
        $validator->addFailure($attribute, 'Invalid');
    }

    /**
     * @return $this
     */
    public function implicit(): static
    {
        $this->implicit = true;

        return $this;
    }

    #[\Override]
    public function setValidator(mixed $validator): ValidatorAwareRule
    {
        $this->validator = $validator;

        return $this;
    }

    #[\Override]
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $passed = $this->passes($attribute, $value, $this->getValidator(), $fail);

        if ($passed === true || $passed === null) {
            return;
        }

        if ($passed === false) {
            $this->fail($attribute, $value, $this->getValidator(), $fail);
        } else {
            foreach ($passed as $k => $v) {
                if (\is_int($k)) {
                    $this->getValidator()->messages()->add($attribute, Assert::nonEmptyString($v));
                } else {
                    $this->getValidator()->addFailure($attribute, $k, Assert::array($v));
                }
            }
        }
    }

    protected function getValidator(): Validator
    {
        return Assert::instance($this->validator, Validator::class);
    }

    /**
     * @param \Closure(string): PotentiallyTranslatedString $fail
     *
     * @return array<int, string>|array<string, array<array-key, mixed>>|bool|null
     */
    abstract public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null;
}
