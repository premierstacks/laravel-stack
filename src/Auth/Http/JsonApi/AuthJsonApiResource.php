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

namespace Premierstacks\LaravelStack\Auth\Http\JsonApi;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Premierstacks\LaravelStack\Auth\Guards\UnlimitedTokenGuard;
use Premierstacks\LaravelStack\Auth\Models\UnlimitedToken;
use Premierstacks\LaravelStack\Container\Resolve;
use Premierstacks\PhpStack\JsonApi\JsonApiRelationship;
use Premierstacks\PhpStack\JsonApi\JsonApiRelationshipInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceIdentifierInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResourceInterface;
use Premierstacks\PhpStack\Types\Strings;

class AuthJsonApiResource extends AuthenticatableJsonApiResource
{
    public function __construct(Authenticatable $authenticatable)
    {
        parent::__construct($authenticatable);
    }

    /**
     * @return JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable<array-key, JsonApiResourceIdentifierInterface|JsonApiResourceInterface>|null
     */
    public function createUnlimitedTokenJsonApiResource(UnlimitedToken|null $unlimitedToken): JsonApiResourceIdentifierInterface|JsonApiResourceInterface|iterable|null
    {
        if ($unlimitedToken === null) {
            return null;
        }

        return UnlimitedTokenJsonApiResource::inject(['unlimitedToken' => $unlimitedToken]);
    }

    public function createUnlimitedTokenRelationship(UnlimitedToken|null $unlimitedToken): JsonApiRelationshipInterface
    {
        return Resolve::inject(JsonApiRelationship::class, parameters: ['data' => $this->createUnlimitedTokenJsonApiResource($unlimitedToken)]);
    }

    /**
     * @return iterable<array-key, mixed>
     */
    #[\Override]
    public function getAttributes(): iterable
    {
        yield from parent::getAttributes();

        yield from $this->getAuthAttributes();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getAuthAttributes(): iterable
    {
        if ($this->authenticatable instanceof CanResetPassword) {
            yield 'email_for_password_reset' => Strings::nullify($this->authenticatable->getEmailForPasswordReset());
        }

        if ($this->authenticatable instanceof MustVerifyEmail) {
            yield 'email_for_verification' => Strings::nullify($this->authenticatable->getEmailForVerification());
        }

        if ($this->authenticatable instanceof Model) {
            yield from $this->authenticatable->attributesToArray();
        }
    }

    /**
     * @return iterable<array-key, JsonApiRelationshipInterface>
     */
    public function getAuthRelationships(): iterable
    {
        $guard = $this->getGuard();

        if ($guard instanceof UnlimitedTokenGuard) {
            yield 'unlimited_token' => $this->createUnlimitedTokenRelationship($guard->getUnlimitedToken());
        }
    }

    public function getGuard(): Guard
    {
        return Resolve::guardContract();
    }

    /**
     * @return iterable<array-key, JsonApiRelationshipInterface>
     */
    #[\Override]
    public function getRelationships(): iterable
    {
        yield from parent::getRelationships() ?? [];

        yield from $this->getAuthRelationships();
    }
}
