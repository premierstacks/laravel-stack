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

namespace Premierstacks\LaravelStack\Http;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolve;

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
        return Resolve::request();
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
