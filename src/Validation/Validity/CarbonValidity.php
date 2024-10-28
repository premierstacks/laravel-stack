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

class CarbonValidity extends MixedValidity
{
    /**
     * @return $this
     */
    public function after(string $dateOrField): static
    {
        return $this->add('after', [$dateOrField]);
    }

    /**
     * @return $this
     */
    public function afterOrEqual(string $dateOrField): static
    {
        return $this->add('after_or_equal', [$dateOrField]);
    }

    /**
     * @return $this
     */
    public function before(string $dateOrField): static
    {
        return $this->add('before', [$dateOrField]);
    }

    /**
     * @return $this
     */
    public function beforeOrEqual(string $dateOrField): static
    {
        return $this->add('before_or_equal', [$dateOrField]);
    }

    /**
     * @return $this
     */
    public function dateEquals(string $dateOrField): static
    {
        return $this->add('date_equals', [$dateOrField]);
    }

    #[\Override]
    public function getBase(): array
    {
        return $this->base ?? ['date'];
    }
}
