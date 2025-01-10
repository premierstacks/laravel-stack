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

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\PhpStack\JsonApi\JsonApiResource;
use Premierstacks\PhpStack\Mixed\Assert;

class AuthenticatableJsonApiResource extends JsonApiResource
{
    use InjectTrait;

    public function __construct(public Authenticatable $authenticatable)
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

        yield from $this->getAuthenticatableAttributes();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getAuthenticatableAttributes(): iterable
    {
        if ($this->authenticatable instanceof HasLocalePreference) {
            yield 'preferred_locale' => $this->authenticatable->preferredLocale();
        }
    }

    public function getGate(): Gate
    {
        return Resolver::gateContract();
    }

    #[\Override]
    public function getId(): string
    {
        $id = parent::getId();

        if ($id !== null) {
            return $id;
        }

        if ($this->authenticatable instanceof Model) {
            return (string) Assert::arrayKey($this->authenticatable->getKey());
        }

        return (string) Assert::arrayKey($this->authenticatable->getAuthIdentifier());
    }

    /**
     * @return iterable<array-key, mixed>
     */
    #[\Override]
    public function getMeta(): iterable
    {
        yield from parent::getMeta() ?? [];
    }

    #[\Override]
    public function getSlug(): string
    {
        $slug = parent::getSlug();

        if ($slug !== null) {
            return $slug;
        }

        if ($this->authenticatable instanceof Model) {
            return (string) Assert::arrayKey($this->authenticatable->getRouteKey());
        }

        return $this->getId();
    }

    #[\Override]
    public function getType(): string
    {
        $type = parent::getType();

        if ($type !== null) {
            return $type;
        }

        if ($this->authenticatable instanceof Model) {
            return $this->authenticatable->getTable();
        }

        return Str::slug($this->authenticatable::class, '_', null);
    }
}
