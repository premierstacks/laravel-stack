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

namespace Premierstacks\LaravelStack\Validation\Validity;

trait SizeValidityTrait
{
    /**
     * @return $this
     */
    public function between(int $min, int $max): static
    {
        $this->min = $min;
        $this->max = $max;

        return $this;
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
    public function max(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return $this
     */
    public function min(int $min): static
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return $this
     */
    public function size(int $size): static
    {
        $this->min = $size;
        $this->max = $size;

        return $this;
    }
}
