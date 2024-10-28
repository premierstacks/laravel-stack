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

namespace Premierstacks\LaravelStack\Http;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolver;

class RequestSignature
{
    use InjectTrait;

    public function __construct(public AuthenticatableContract|null $authenticatable) {}

    public function getHash(): string
    {
        $request = $this->getRequest();

        return \hash('sha256', \serialize([
            $this->authenticatable === null ? null : $this->authenticatable::class,
            $this->authenticatable?->getAuthIdentifier(),
            $request->ip(),
            $request->path(),
            $request->method(),
        ]));
    }

    public function getRequest(): Request
    {
        return Resolver::request();
    }

    /**
     * @return $this
     */
    public function setAuthenticatable(AuthenticatableContract|null $authenticatable): static
    {
        $this->authenticatable = $authenticatable;

        return $this;
    }
}
