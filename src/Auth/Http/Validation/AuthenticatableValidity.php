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
