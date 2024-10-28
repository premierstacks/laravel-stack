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

namespace Premierstacks\LaravelStack\Auth\Models;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Translation\HasLocalePreference as HasLocalePreferenceContract;
use Illuminate\Foundation\Auth\User as IlluminateUser;
use Illuminate\Notifications\Notifiable;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\LaravelStack\Eloquent\MixedModelTrait;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Types\Strings;

abstract class MixedAuthenticatable extends IlluminateUser implements HasLocalePreferenceContract
{
    use MixedModelTrait;
    use Notifiable;

    /**
     * @var array<array-key, mixed>
     */
    protected $attributes = [
        'id' => null,
        'email' => null,
        'password' => null,
        'locale' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * @var array<array-key, mixed>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    protected $fillable = ['email', 'password', 'locale'];

    protected $hidden = ['password'];

    #[\Override]
    public function getAuthIdentifier(): int|string
    {
        return Assert::arrayKey(parent::getAuthIdentifier());
    }

    #[\Override]
    public function getAuthPassword(): string
    {
        return Assert::nullableString(parent::getAuthPassword()) ?? '';
    }

    #[\Override]
    public function getEmailForPasswordReset(): string
    {
        return Assert::nullableString(parent::getEmailForPasswordReset()) ?? '';
    }

    #[\Override]
    public function getRememberToken(): string
    {
        return Assert::nullableString(parent::getRememberToken()) ?? '';
    }

    #[\Override]
    public function getRememberTokenName(): string
    {
        return '';
    }

    #[\Override]
    public function preferredLocale(): string|null
    {
        return Assert::nullableString($this->getAttribute('locale'));
    }

    public function routeNotificationForMail(): string|null
    {
        $email = Strings::nullify($this->getEmailForPasswordReset());

        if ($email !== null) {
            return $email;
        }

        if ($this->attributeLoaded('email')) {
            return Assert::nullableString($this->getAttribute('email'));
        }

        return null;
    }

    public static function authenticate(string|null $guardName = null): static|null
    {
        if ($guardName === null) {
            $authenticatable = Resolver::authenticatableContract();
        } else {
            $authenticatable = Resolver::authManager()->guard($guardName)->user();
        }

        if ($authenticatable instanceof static) {
            return $authenticatable;
        }

        return null;
    }

    public static function mustAuthenticate(string|null $guardName = null): static
    {
        return static::authenticate($guardName) ?? throw new AuthenticationException(guards: [$guardName]);
    }
}
