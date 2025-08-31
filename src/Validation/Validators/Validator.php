<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Validation\Validators;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator as IlluminateValidator;

class Validator extends IlluminateValidator
{
    public $excludeUnvalidatedArrayKeys = true;

    protected $stopOnFirstFailure = true;

    /**
     * @param array<array-key, mixed> $data
     *
     * @return array<array-key, mixed>
     */
    public function dot(array $data, string $prepend = ''): array
    {
        $results = [];

        foreach ($data as $key => $value) {
            $results[$prepend . $key] = null;

            if (\is_array($value)) {
                $results = \array_replace($results, $this->dot($value, $prepend . $key . '.'));
            }
        }

        return $results;
    }

    #[\Override]
    public function passes(): bool
    {
        $this->messages = new MessageBag();

        if (isset($this->rules[''])) {
            foreach (\array_keys(\array_diff_key($this->dot($this->data), $this->rules)) as $attribute) {
                $this->addFailure((string) $attribute, 'Missing');
            }
        }

        return $this->messages->isEmpty() && parent::passes();
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return array<array-key, mixed>
     */
    #[\Override]
    protected function convertValuesToBoolean(mixed $values): array
    {
        return \array_map(static function (mixed $value): mixed {
            return match ($value) {
                'TRUE', 'True', 'true', '1', 1 => true,
                'FALSE', 'False', 'false', '0', 0 => false,
                default => $value,
            };
        }, $values);
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return array<array-key, mixed>
     */
    #[\Override]
    protected function convertValuesToNull(mixed $values): array
    {
        return \array_map(static function (mixed $value): mixed {
            return match ($value) {
                'NULL', 'Null', 'null', '' => null,
                default => $value,
            };
        }, $values);
    }

    #[\Override]
    protected function shouldStopValidating(mixed $attribute): bool
    {
        if ($this->messages->has($this->replacePlaceholderInString($attribute))) {
            return true;
        }

        return parent::shouldStopValidating($attribute);
    }
}
