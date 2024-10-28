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

namespace Premierstacks\LaravelStack\Auth\Http\Validation;

use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Validation\Validity\BooleanValidity;
use Premierstacks\LaravelStack\Validation\Validity\IntegerValidity;
use Premierstacks\LaravelStack\Validation\Validity\StringValidity;
use Premierstacks\LaravelStack\Validation\Validity\Validity;

class AuthenticatableValidity
{
    use InjectTrait;

    public function email(): StringValidity
    {
        return Validity::string()
            ->varchar()
            ->email();
    }

    public function id(): IntegerValidity
    {
        return Validity::integer()->unsignedBigInt(min: 1);
    }

    public function locale(): StringValidity
    {
        return Validity::string()->in(Conf::inject()->getAppLocales());
    }

    public function password(): StringValidity
    {
        return Validity::string()->between(6, 1_024);
    }

    public function remember(): BooleanValidity
    {
        return Validity::boolean();
    }
}
