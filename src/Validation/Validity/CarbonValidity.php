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
