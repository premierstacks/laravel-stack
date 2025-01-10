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

namespace Premierstacks\LaravelStack\Auth\Models;

use Premierstacks\LaravelStack\Eloquent\IntModelTrait;
use Premierstacks\PhpStack\Mixed\Assert;

abstract class IntAuthenticatable extends MixedAuthenticatable
{
    use IntModelTrait;

    #[\Override]
    public function getAuthIdentifier(): int
    {
        return Assert::int(parent::getAuthIdentifier());
    }
}
