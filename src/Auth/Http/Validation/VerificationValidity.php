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

use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Validation\Validity\StringValidity;
use Premierstacks\LaravelStack\Validation\Validity\Validity;

class VerificationValidity
{
    use InjectTrait;

    public function sessionId(): StringValidity
    {
        return Validity::string()->between(40, 256);
    }

    public function token(): StringValidity
    {
        return Validity::string()->between(4, 256);
    }

    public function url(): StringValidity
    {
        return Validity::string()
            ->max(1_024)
            ->url();
    }

    public function verificationId(): StringValidity
    {
        return Validity::string()->between(40, 256);
    }
}
