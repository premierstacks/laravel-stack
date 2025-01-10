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

namespace Premierstacks\LaravelStack\Validation\Validity;

class BooleanValidity extends MixedValidity
{
    /**
     * @return $this
     */
    public function accepted(): static
    {
        return $this->add('accepted');
    }

    /**
     * @param array<array-key, scalar|null> $values
     *
     * @return $this
     */
    public function acceptedIf(string $field, array $values): static
    {
        return $this->add('accepted_if', [$field, ...$values]);
    }

    /**
     * @return $this
     */
    public function declined(): static
    {
        return $this->add('declined');
    }

    /**
     * @param array<array-key, scalar|null> $values
     *
     * @return $this
     */
    public function declinedIf(string $field, array $values): static
    {
        return $this->add('declined_if', [$field, ...$values]);
    }

    /**
     * @return $this
     */
    public function false(): static
    {
        return $this->add('in', [false]);
    }

    #[\Override]
    public function getBase(): array
    {
        return $this->base ?? ['boolean'];
    }

    /**
     * @return $this
     */
    public function true(): static
    {
        return $this->add('in', [true]);
    }
}
