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

namespace Premierstacks\LaravelStack\Auth\Http\JsonApi;

use Premierstacks\LaravelStack\Auth\Models\UnlimitedToken;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\JsonApi\JsonApiResource;

class UnlimitedTokenJsonApiResource extends JsonApiResource
{
    use InjectTrait;

    public function __construct(public UnlimitedToken $unlimitedToken)
    {
        parent::__construct();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    #[\Override]
    public function getAttributes(): iterable
    {
        yield from parent::getAttributes() ?? [];

        yield from $this->getUnlimitedTokenAttributes();
    }

    #[\Override]
    public function getId(): string
    {
        return parent::getId() ?? (string) $this->unlimitedToken->getKey();
    }

    #[\Override]
    public function getSlug(): string
    {
        return parent::getId() ?? $this->unlimitedToken->getRouteKey();
    }

    #[\Override]
    public function getType(): string
    {
        return parent::getType() ?? $this->unlimitedToken->getTable();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getUnlimitedTokenAttributes(): iterable
    {
        yield 'bearer_token' => $this->unlimitedToken->getBearerToken();

        yield 'authenticatable_id' => $this->unlimitedToken->getAuthenticatableId();

        yield 'guard_name' => $this->unlimitedToken->getGuardName();

        yield 'user_provider_name' => $this->unlimitedToken->getUserProviderName();

        yield 'ip' => $this->unlimitedToken->getIp();

        yield 'user_agent' => $this->unlimitedToken->getUserAgent();

        yield 'origin' => $this->unlimitedToken->getOrigin();

        yield 'revoked_at' => $this->unlimitedToken->getRevokedAt()?->toJSON();
    }
}
