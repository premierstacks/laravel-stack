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

use Premierstacks\LaravelStack\Validation\Rules\FloatRule;

class FloatValidity extends MixedValidity
{
    use ScalarValidityTrait;

    /**
     * @return $this
     */
    public function between(float $min, float $max): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->min = $min;
        $this->max = $max;

        return $this;
    }

    /**
     * @return $this
     */
    public function decimal(int $min, int|null $max = null): static
    {
        return $this->add('decimal', $max === null ? [$min] : [$min, $max]);
    }

    #[\Override]
    public function getBase(): array
    {
        return $this->base ?? ['numeric', new FloatRule()];
    }

    /**
     * @return $this
     */
    public function gt(string $field): static
    {
        return $this->add('gt', [$field]);
    }

    /**
     * @return $this
     */
    public function gte(string $field): static
    {
        return $this->add('gte', [$field]);
    }

    /**
     * @return $this
     */
    public function lt(string $field): static
    {
        return $this->add('lt', [$field]);
    }

    /**
     * @return $this
     */
    public function lte(string $field): static
    {
        return $this->add('lte', [$field]);
    }

    /**
     * @return $this
     */
    public function max(float $max): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->max = $max;

        return $this;
    }

    /**
     * @return $this
     */
    public function min(float $min): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->min = $min;

        return $this;
    }

    /**
     * @return $this
     */
    public function multipleOf(float $multipleOf): static
    {
        return $this->add('multiple_of', [$multipleOf]);
    }

    /**
     * @return $this
     */
    public function size(float $size): static
    {
        if ($this->skip > 0) {
            return $this->unskip();
        }

        $this->min = $size;
        $this->max = $size;

        return $this;
    }
}