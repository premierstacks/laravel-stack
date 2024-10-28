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

namespace Premierstacks\LaravelStack\Validation\Validity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Validation\Rules\CallbackRule;
use Premierstacks\LaravelStack\Validation\Rules\ValidateRule;
use Premierstacks\PhpStack\Mixed\Assert;

class MixedValidity
{
    public bool $bail = false;

    /**
     * @var array<array-key, mixed>|null
     */
    public array|null $base = null;

    public bool $filled = false;

    /**
     * @var array<array-key, mixed>|null
     */
    public array|null $in = null;

    public float|int|null $max = null;

    public float|int|null $min = null;

    public bool $missing = false;

    /**
     * @var array<array-key, mixed>|null
     */
    public array|null $notIn = null;

    public bool $nullable = false;

    public bool $present = false;

    public bool $prohibited = false;

    public bool $required = false;

    /**
     * @var array<array-key, ValidationRule|string>
     */
    public array $rules = [];

    public int $skip = 0;

    public bool $sometimes = false;

    public function __construct() {}

    /**
     * @param array<array-key, mixed>|null $arguments
     *
     * @return $this
     */
    public function add(ValidationRule|string $rule, array|null $arguments = null): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        if (\is_string($rule)) {
            $rule = $this->encodeRule($rule, $arguments);
        }

        if (!\in_array($rule, $this->rules, true)) {
            $this->rules[] = $rule;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function bail(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->bail = true;

        return $this;
    }

    /**
     * @param \Closure(string, mixed, Validator, \Closure(string): PotentiallyTranslatedString $fail): (array<int, string>|array<string, array<array-key, mixed>>|bool|null) $callback
     *
     * @return $this
     */
    public function closure(\Closure $callback): static
    {
        return $this->add(new CallbackRule($callback));
    }

    /**
     * @return array<array-key, mixed>
     */
    public function compile(): array
    {
        $rules = [];

        if ($this->bail) {
            $rules[] = 'bail';
        }

        if ($this->sometimes) {
            $rules[] = 'sometimes';
        }

        if ($this->missing) {
            $rules[] = 'missing';
        }

        if ($this->prohibited) {
            $rules[] = 'prohibited';
        }

        if ($this->nullable) {
            $rules[] = 'nullable';
        }

        if ($this->present) {
            $rules[] = 'present';
        }

        if ($this->filled) {
            $rules[] = 'filled';
        }

        if ($this->required) {
            $rules[] = 'required';
        }

        $rules = \array_merge($rules, $this->getBase());

        if ($this->in !== null) {
            $rules[] = $this->encodeRule('in', $this->in);
        }

        if ($this->notIn !== null) {
            $rules[] = $this->encodeRule('notIn', $this->notIn);
        }

        $rules = \array_merge($rules, $this->getMinMax());

        return \array_merge($rules, $this->rules);
    }

    /**
     * @return $this
     */
    public function different(string $field): static
    {
        return $this->add('different', [$field]);
    }

    /**
     * @return $this
     */
    public function distinct(bool $strict = false, bool $ignoreCase = true): static
    {
        $options = [];

        if ($strict) {
            $options[] = 'strict';
        }

        if ($ignoreCase) {
            $options[] = 'ignore_case';
        }

        return $this->add('distinct', $options);
    }

    /**
     * @param array<array-key, mixed>|null $arguments
     */
    public function encodeRule(string $rule, array|null $arguments = null): string
    {
        if ($arguments !== null && $arguments !== []) {
            $encoded = \array_map(static function (mixed $value) {
                $value = match (true) {
                    $value instanceof \BackedEnum => $value->value,
                    $value instanceof \UnitEnum => $value->name,
                    \is_bool($value) => $value ? '1' : '0',
                    default => Assert::nullableScalar($value),
                };

                return '"' . \str_replace('"', '""', (string) $value) . '"';
            }, $arguments);

            return $rule . ':' . \implode(',', $encoded);
        }

        return $rule;
    }

    /**
     * @return $this
     */
    public function exclude(): static
    {
        return $this->add('exclude');
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function excludeIf(string $field, array $values): static
    {
        return $this->add('exclude_if', [$field, ...$values]);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function excludeUnless(string $field, array $values): static
    {
        return $this->add('exclude_unless', [$field, ...$values]);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function excludeWith(array $fields): static
    {
        return $this->add('exclude_with', $fields);
    }

    /**
     * @return $this
     */
    public function excludeWithout(string $field): static
    {
        return $this->add('exclude_without', [$field]);
    }

    /**
     * @return $this
     */
    public function filled(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->filled = true;

        return $this;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getBase(): array
    {
        return $this->base ?? [];
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getMinMax(): array
    {
        $rules = [];

        if ($this->min !== null && $this->max !== null) {
            if ($this->min === $this->max) {
                $rules[] = $this->encodeRule('size', [$this->min]);
            } else {
                $rules[] = $this->encodeRule('between', [$this->min, $this->max]);
            }
        } elseif ($this->min !== null) {
            $rules[] = $this->encodeRule('min', [$this->min]);
        } elseif ($this->max !== null) {
            $rules[] = $this->encodeRule('max', [$this->max]);
        }

        return $rules;
    }

    /**
     * @param bool|callable(): bool $flag
     *
     * @return $this
     */
    public function if(bool|callable $flag, int $skip = 1): static
    {
        if (\is_callable($flag)) {
            $flag = $flag();
        }

        if (!$flag) {
            return $this->skip($skip);
        }

        return $this;
    }

    /**
     * @param bool|callable(): bool $flag
     *
     * @return $this
     */
    public function ifNot(bool|callable $flag, int $skip = 1): static
    {
        if (\is_callable($flag)) {
            $flag = $flag();
        }

        if ($flag) {
            return $this->skip($skip);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function missing(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->missing = true;

        return $this;
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function missingIf(string $field, array $values): static
    {
        return $this->add('missing_if', [$field, ...$values]);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function missingUnless(string $field, array $values): static
    {
        return $this->add('missing_unless', [$field, ...$values]);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function missingWith(array $fields): static
    {
        return $this->add('missing_with', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function missingWithAll(array $fields): static
    {
        return $this->add('missing_with_all', $fields);
    }

    /**
     * @return $this
     */
    public function nullable(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->nullable = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function present(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->present = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function prohibited(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->prohibited = true;

        return $this;
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function prohibitedIf(string $field, array $values): static
    {
        return $this->add('prohibited_if', [$field, ...$values]);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function prohibitedUnless(string $field, array $values): static
    {
        return $this->add('prohibited_unless', [$field, ...$values]);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function prohibitedWith(array $fields): static
    {
        return $this->add('prohibited_with', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function prohibitedWithAll(array $fields): static
    {
        return $this->add('prohibited_with_all', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function prohibitedWithout(array $fields): static
    {
        return $this->add('prohibited_without', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function prohibitedWithoutAll(array $fields): static
    {
        return $this->add('prohibited_without_all', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function prohibits(array $fields): static
    {
        return $this->add('prohibits', $fields);
    }

    /**
     * @return $this
     */
    public function required(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->required = true;

        return $this;
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function requiredIf(string $field, array $values): static
    {
        return $this->add('required_if', [$field, ...$values]);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return $this
     */
    public function requiredUnless(string $field, array $values): static
    {
        return $this->add('required_unless', [$field, ...$values]);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function requiredWith(array $fields): static
    {
        return $this->add('required_with', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function requiredWithAll(array $fields): static
    {
        return $this->add('required_with_all', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function requiredWithout(array $fields): static
    {
        return $this->add('required_without', $fields);
    }

    /**
     * @param array<array-key, string> $fields
     *
     * @return $this
     */
    public function requiredWithoutAll(array $fields): static
    {
        return $this->add('required_without_all', $fields);
    }

    /**
     * @param array<array-key, mixed> $base
     *
     * @return $this
     */
    public function setBase(array $base): static
    {
        $this->base = $base;

        return $this;
    }

    /**
     * @return $this
     */
    public function skip(int $skip = 1): static
    {
        $this->skip += $skip;

        return $this;
    }

    /**
     * @return $this
     */
    public function sometimes(): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->sometimes = true;

        return $this;
    }

    /**
     * @param \Closure(static): void $callback
     *
     * @return $this
     */
    public function tap(\Closure $callback): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $callback($this);

        return $this;
    }

    /**
     * @return $this
     */
    public function unskip(int $skip = 1): static
    {
        $this->skip -= $skip;

        return $this;
    }

    /**
     * @param \Closure(string, mixed): array<array-key, mixed> $callback
     *
     * @return $this
     */
    public function validate(\Closure $callback): static
    {
        return $this->add(new ValidateRule($callback));
    }
}