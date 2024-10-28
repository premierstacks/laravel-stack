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
