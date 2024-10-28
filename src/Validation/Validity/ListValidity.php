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
