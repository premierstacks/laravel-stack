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

use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Validation\Rules\BytesBetweenRule;
use Premierstacks\LaravelStack\Validation\Rules\BytesMaxRule;
use Premierstacks\LaravelStack\Validation\Rules\BytesMinRule;
use Premierstacks\LaravelStack\Validation\Rules\BytesSizeRule;
use Premierstacks\LaravelStack\Validation\Rules\CursorRule;
use Premierstacks\LaravelStack\Validation\Rules\EnumRule;

class StringValidity extends MixedValidity
{
    use ScalarValidityTrait;
    use SizeValidityTrait;

    /**
     * @return $this
     */
    public function activeUrl(): static
    {
        if (Conf::inject()->isAppEnv(['testing'])) {
            return $this->add('url');
        }

        return $this->add('active_url');
    }

    /**
     * @return $this
     */
    public function alpha(): static
    {
        return $this->add('alpha');
    }

    /**
     * @return $this
     */
    public function alphaDash(): static
    {
        return $this->add('alpha_dash');
    }

    /**
     * @return $this
     */
    public function alphaNum(): static
    {
        return $this->add('alpha_num');
    }

    /**
     * @return $this
     */
    public function ascii(): static
    {
        return $this->add('ascii');
    }

    /**
     * @return $this
     */
    public function currentPassword(string|null $guard = null): static
    {
        return $this->add('current_password', $guard !== null ? [$guard] : null);
    }

    /**
     * @return $this
     */
    public function cursor(): static
    {
        return $this->add(new CursorRule());
    }

    /**
     * @return $this
     */
    public function digits(int $length): static
    {
        return $this->add('digits', [$length]);
    }

    /**
     * @return $this
     */
    public function digitsBetween(int $minLength, int $maxLength): static
    {
        return $this->add('digits_between', [$minLength, $maxLength]);
    }

    /**
     * @param array<array-key, string> $ends
     *
     * @return $this
     */
    public function doesntEndWith(array $ends): static
    {
        return $this->add('doesnt_end_with', $ends);
    }

    /**
     * @param array<array-key, string> $ends
     *
     * @return $this
     */
    public function doesntStartWith(array $ends): static
    {
        return $this->add('doesnt_start_with', $ends);
    }

    /**
     * @return $this
     */
    public function email(bool $filterUnicode = true, bool $strict = true, bool $dns = true, bool $rfc = false, bool $spoof = true, bool $filter = false): static
    {
        if (Conf::inject()->isAppEnv(['testing'])) {
            return $this->add('email');
        }

        $options = [];

        if ($filter) {
            $options[] = 'filter';
        }

        if ($filterUnicode) {
            $options[] = 'filter_unicode';
        }

        if ($strict) {
            $options[] = 'strict';
        }

        if ($dns) {
            $options[] = 'dns';
        }

        if ($rfc) {
            $options[] = 'rfc';
        }

        if ($spoof) {
            $options[] = 'spoof';
        }

        return $this->add('email', $options);
    }

    /**
     * @param array<array-key, string> $ends
     *
     * @return $this
     */
    public function endsWith(array $ends): static
    {
        return $this->add('ends_with', $ends);
    }

    /**
     * @param class-string<\BackedEnum> $enum
     *
     * @return $this
     */
    public function enum(string $enum): static
    {
        return $this->add(new EnumRule($enum));
    }

    #[\Override]
    public function getBase(): array
    {
        return $this->base ?? ['string'];
    }

    #[\Override]
    public function getMinMax(): array
    {
        $rules = [];

        if ($this->min !== null && $this->max !== null) {
            if ($this->min === $this->max) {
                $rules[] = new BytesSizeRule($this->min);
            } else {
                $rules[] = new BytesBetweenRule($this->min, $this->max);
            }
        } elseif ($this->min !== null) {
            $rules[] = new BytesMinRule($this->min);
        } elseif ($this->max !== null) {
            $rules[] = new BytesMaxRule($this->max);
        }

        return $rules;
    }

    /**
     * @return $this
     */
    public function ip(): static
    {
        return $this->add('ip');
    }

    /**
     * @return $this
     */
    public function ipv4(): static
    {
        return $this->add('ipv4');
    }

    /**
     * @return $this
     */
    public function ipv6(): static
    {
        return $this->add('ipv6');
    }

    /**
     * @return $this
     */
    public function json(): static
    {
        return $this->add('json');
    }

    /**
     * @return $this
     */
    public function lowercase(): static
    {
        return $this->add('lowercase');
    }

    /**
     * @return $this
     */
    public function macAddress(): static
    {
        return $this->add('mac_address');
    }

    /**
     * @return $this
     */
    public function maxDigits(int $max): static
    {
        return $this->add('max_digits', [$max]);
    }

    /**
     * @return $this
     */
    public function minDigits(int $min): static
    {
        return $this->add('min_digits', [$min]);
    }

    /**
     * @return $this
     */
    public function notRegex(string $pattern): static
    {
        return $this->add('not_regex', [$pattern]);
    }

    /**
     * @return $this
     */
    public function regex(string $pattern): static
    {
        return $this->add('regex', [$pattern]);
    }

    /**
     * @param array<array-key, string> $startsWith
     *
     * @return $this
     */
    public function startsWith(array $startsWith): static
    {
        return $this->add('starts_with', $startsWith);
    }

    /**
     * @return $this
     */
    public function strlen(int $length): static
    {
        return $this->add('strlen', [$length]);
    }

    /**
     * @return $this
     */
    public function strlenMax(int $max): static
    {
        return $this->add('strlen_max', [$max]);
    }

    /**
     * @return $this
     */
    public function strlenMin(int $min): static
    {
        return $this->add('strlen_min', [$min]);
    }

    /**
     * @return $this
     */
    public function timezone(): static
    {
        return $this->add('timezone');
    }

    /**
     * @return $this
     */
    public function ulid(): static
    {
        return $this->add('ulid');
    }

    /**
     * @return $this
     */
    public function uppercase(): static
    {
        return $this->add('uppercase');
    }

    /**
     * @return $this
     */
    public function url(): static
    {
        return $this->add('url');
    }

    /**
     * @return $this
     */
    public function uuid(): static
    {
        return $this->add('uuid');
    }
}
