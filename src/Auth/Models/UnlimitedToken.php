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

namespace Premierstacks\LaravelStack\Auth\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Premierstacks\LaravelStack\Auth\Guards\UnlimitedTokenGuard;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Eloquent\IntModel;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;
use Premierstacks\PhpStack\Random\Random;

class UnlimitedToken extends IntModel
{
    public string|null $rawToken = null;

    protected $attributes = [
        'id' => null,
        'token' => null,
        'authenticatable_id' => null,
        'guard_name' => null,
        'user_provider_name' => null,
        'ip' => null,
        'user_agent' => null,
        'origin' => null,
        'password' => null,
        'revoked_at' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * @var array<array-key, mixed>
     */
    protected $casts = [
        'token' => 'string',
        'authenticatable_id' => 'string',
        'guard_name' => 'string',
        'user_provider_name' => 'string',
        'ip' => 'string',
        'user_agent' => 'string',
        'origin' => 'string',
        'password' => 'string',
        'revoked_at' => 'datetime',
    ];

    protected $fillable = ['token', 'authenticatable_id', 'guard_name', 'user_provider_name', 'ip', 'user_agent', 'origin', 'password', 'revoked_at'];

    protected $hidden = ['token', 'password'];

    /**
     * @return $this
     */
    public function asRevoked(): static
    {
        return $this->fill([
            'revoked_at' => $this->freshTimestamp(),
        ]);
    }

    /**
     * @return $this
     */
    public function generateToken(): static
    {
        return $this->setToken($this->randomToken());
    }

    public function getAuthenticatableId(): string
    {
        return Assert::nonEmptyString($this->getAttribute('authenticatable_id'));
    }

    public function getBearerToken(): string|null
    {
        if (!$this->exists) {
            return null;
        }

        if ($this->getRawToken() === null) {
            return null;
        }

        return $this->getKey() . '|' . $this->getRawToken();
    }

    #[\Override]
    public function getCreatedAt(): Carbon
    {
        return Assert::instance(parent::getCreatedAt(), Carbon::class);
    }

    public function getGuardName(): string
    {
        return Assert::nonEmptyString($this->getAttribute('guard_name'));
    }

    public function getIp(): string|null
    {
        return Assert::nullableNonEmptyString($this->getAttribute('ip'));
    }

    public function getOrigin(): string|null
    {
        return Assert::nullableNonEmptyString($this->getAttribute('origin'));
    }

    public function getPassword(): string|null
    {
        return Assert::nullableNonEmptyString($this->getAttribute('password'));
    }

    public function getRawToken(): string|null
    {
        return $this->rawToken;
    }

    public function getRevokedAt(): Carbon|null
    {
        return Assert::nullableInstance($this->getAttribute('revoked_at'), Carbon::class);
    }

    public function getToken(): string
    {
        return Assert::nonEmptyString($this->getAttribute('token'));
    }

    #[\Override]
    public function getUpdatedAt(): Carbon
    {
        return Assert::instance(parent::getUpdatedAt(), Carbon::class);
    }

    public function getUserAgent(): string|null
    {
        return Assert::nullableNonEmptyString($this->getAttribute('user_agent'));
    }

    public function getUserProviderName(): string
    {
        return Assert::nonEmptyString($this->getAttribute('user_provider_name'));
    }

    public function hash(string $data): string
    {
        return \hash_hmac('sha256', $data, Conf::inject()->getAppKey());
    }

    public function isActive(): bool
    {
        return $this->getRevokedAt() === null;
    }

    public function randomToken(): string
    {
        return Random::alnum();
    }

    public function retrieveByBearerToken(string $bearerToken): static|null
    {
        if (!\str_contains($bearerToken, '|')) {
            return null;
        }

        $exploded = \explode('|', $bearerToken, 2);

        if (!isset($exploded[0], $exploded[1])) {
            return null;
        }

        $key = Filter::nullablePositiveInt($exploded[0], null);
        $rawToken = Filter::nullableNonEmptyString($exploded[1], null);

        if ($key === null || $rawToken === null) {
            return null;
        }

        $found = $this->newQuery()->whereKey($key)->first();

        if (!$found instanceof static) {
            return null;
        }

        if (!$found->validateToken($rawToken)) {
            return null;
        }

        $found->setRawToken($rawToken);

        return $found;
    }

    /**
     * @param array<array-key, mixed> $except
     */
    public function revokeAllDevices(array $except = []): int
    {
        $query = $this->newQuery();

        $this->scopeOtherDevices($query);

        return $query->whereKeyNot($except)
            ->where('revoked_at', null)
            ->update(['revoked_at' => $this->freshTimestamp()]);
    }

    /**
     * @param array<array-key, mixed> $except
     */
    public function revokeOtherDevices(array $except = []): int
    {
        return $this->revokeAllDevices([$this->getKey(), ...$except]);
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     *
     * @return Builder<T>
     */
    public function scopeOtherDevices(Builder $builder): Builder
    {
        return $builder
            ->where('authenticatable_id', $this->getAuthenticatableId())
            ->where('guard_name', $this->getGuardName())
            ->where('user_provider_name', $this->getUserProviderName());
    }

    /**
     * @return $this
     */
    public function setAuthenticatable(AuthenticatableContract $authenticatable): static
    {
        if ($authenticatable instanceof Model) {
            $this->setAttribute($authenticatable->getForeignKey(), $authenticatable->getKey());
        }

        return $this->fill([
            'authenticatable_id' => $authenticatable->getAuthIdentifier(),
            'password' => $authenticatable->getAuthPassword(),
        ]);
    }

    /**
     * @return $this
     */
    public function setRawToken(string|null $rawToken): static
    {
        $this->rawToken = $rawToken;

        return $this;
    }

    /**
     * @return $this
     */
    public function setToken(string $token): static
    {
        $this->setRawToken($token);

        return $this->fill([
            'token' => $this->hash($token),
        ]);
    }

    /**
     * @return $this
     */
    public function setUnlimitedTokenGuard(UnlimitedTokenGuard $unlimitedTokenGuard): static
    {
        $request = $unlimitedTokenGuard->getRequest();

        return $this->fill([
            'guard_name' => $unlimitedTokenGuard->getGuardName(),
            'user_provider_name' => $unlimitedTokenGuard->getUserProviderName(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'origin' => $request->headers->get('Origin'),
        ]);
    }

    /**
     * @return $this
     */
    public function syncAuthenticatable(AuthenticatableContract $authenticatable): static
    {
        if ($this->getPassword() !== $authenticatable->getAuthPassword()) {
            $this->mustUpdate([
                'password' => $authenticatable->getAuthPassword(),
            ]);
        }

        return $this;
    }

    public function validateToken(string $rawToken): bool
    {
        return \hash_equals($this->getToken(), $this->hash($rawToken));
    }
}
