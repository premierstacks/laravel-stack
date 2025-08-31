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

use Premierstacks\LaravelStack\Validation\Rules\KeyRule;
use Premierstacks\LaravelStack\Validation\Rules\KeysRule;
use Premierstacks\LaravelStack\Validation\Rules\ListRule;

class ListValidity extends MixedValidity
{
    use SizeValidityTrait;

    #[\Override]
    public function getBase(): array
    {
        return $this->base ?? ['array', new ListRule()];
    }

    /**
     * @param array<array-key, array-key> $keys
     *
     * @return $this
     */
    public function key(array $keys, bool $required = false): static
    {
        return $this->add(new KeyRule($keys, $required));
    }

    /**
     * @param array<array-key, array-key> $keys
     *
     * @return $this
     */
    public function keys(array $keys, bool $required = false): static
    {
        return $this->add(new KeysRule($keys, $required));
    }
}
