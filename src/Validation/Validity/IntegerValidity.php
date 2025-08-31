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

use Premierstacks\LaravelStack\Validation\Rules\EnumRule;

class IntegerValidity extends MixedValidity
{
    use ScalarValidityTrait;
    use SizeValidityTrait;

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
        return $this->base ?? ['integer'];
    }

    /**
     * @return $this
     */
    public function multipleOf(int $multipleOf): static
    {
        return $this->add('multiple_of', [$multipleOf]);
    }
}
