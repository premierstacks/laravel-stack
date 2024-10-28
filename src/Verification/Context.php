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

namespace Premierstacks\LaravelStack\Verification;

use Premierstacks\LaravelStack\Container\InjectTrait;

class Context implements ContextInterface
{
    use InjectTrait;

    /**
     * @var array<array-key, iterable<array-key, mixed>>
     */
    public array $contextCollection = [];

    /**
     * @param iterable<array-key, mixed> $context
     */
    public function __construct(iterable $context = [])
    {
        if ($context !== []) {
            $this->push($context);
        }
    }

    #[\Override]
    public function getIterator(): \Traversable
    {
        foreach ($this->contextCollection as $context) {
            yield from $context;
        }
    }

    /**
     * @param iterable<array-key, mixed> $context
     *
     * @return $this
     */
    public function push(iterable $context): static
    {
        if ($context !== []) {
            $this->contextCollection[] = $context;
        }

        return $this;
    }
}
