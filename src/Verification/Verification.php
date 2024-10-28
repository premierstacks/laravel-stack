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

namespace Premierstacks\LaravelStack\Verification;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Eloquent\MixedModel;
use Premierstacks\PhpStack\Mixed\Assert;

class Verification extends MixedModel implements VerificationInterface
{
    public string|null $rawToken = null;

    /**
     * @var array<array-key, mixed>
     */
    protected $attributes = [
        'id' => null,
        'session_id' => null,
        'context' => null,
        'duration' => null,
        'expires_at' => null,
        'verified_at' => null,
        'verification_id' => null,
        'token' => null,
        'uses' => null,
        'action' => null,
        'pair' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * @var array<array-key, mixed>
     */
    protected $casts = [
        'session_id' => 'string',
        'context' => 'string',
        'duration' => 'int',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'verification_id' => 'string',
        'token' => 'string',
        'uses' => 'int',
        'action' => 'string',
        'pair' => 'string',
    ];

    protected $fillable = [
        'session_id',
        'context',
        'duration',
        'expires_at',
        'verified_at',
        'verification_id',
        'token',
        'uses',
        'action',
        'pair',
    ];

    protected $hidden = ['token'];

    /**
     * @return $this
     */
    public function asVerified(): static
    {
        return $this->fill([
            'verified_at' => $this->freshTimestamp(),
            'expires_at' => $this->freshTimestamp()->addSeconds($this->getDuration()),
        ]);
    }

    /**
     * @param iterable<array-key, mixed> $context
     */
    public function contextHash(iterable $context): string
    {
        $array = \iterator_to_array($context);

        \ksort($array);

        return $this->hash(\serialize($array));
    }

    public function decrementUses(): bool
    {
        return $this->decrement('uses') > 0;
    }

    #[\Override]
    public function getAction(): string
    {
        return Assert::string($this->getAttribute('action'));
    }

    #[\Override]
    public function getContext(): string
    {
        return Assert::string($this->getAttribute('context'));
    }

    #[\Override]
    public function getDuration(): int
    {
        return Assert::int($this->getAttribute('duration'));
    }

    #[\Override]
    public function getExpiresAt(): Carbon
    {
        return Assert::instance($this->getAttribute('expires_at'), Carbon::class);
    }

    #[\Override]
    public function getPair(): string
    {
        return Assert::string($this->getAttribute('pair'));
    }

    public function getRawToken(): string|null
    {
        return $this->rawToken;
    }

    #[\Override]
    public function getSessionId(): string
    {
        return Assert::string($this->getAttribute('session_id'));
    }

    #[\Override]
    public function getToken(): string
    {
        return Assert::string($this->getAttribute('token'));
    }

    #[\Override]
    public function getUses(): int
    {
        return Assert::int($this->getAttribute('uses'));
    }

    #[\Override]
    public function getVerificationId(): string
    {
        return Assert::string($this->getAttribute('verification_id'));
    }

    #[\Override]
    public function getVerifiedAt(): Carbon|null
    {
        return Assert::nullableInstance($this->getAttribute('verified_at'), Carbon::class);
    }

    public function hash(string $data): string
    {
        return \hash_hmac('sha256', $data, Conf::inject()->getAppKey());
    }

    #[\Override]
    public function isActive(): bool
    {
        return $this->isCompleted() && $this->getExpiresAt()->isFuture() && $this->getUses() > 0;
    }

    #[\Override]
    public function isCompleted(): bool
    {
        return $this->getVerifiedAt() !== null && $this->getVerifiedAt()->isPast();
    }

    #[\Override]
    public function isReady(): bool
    {
        return $this->getVerifiedAt() === null && $this->getExpiresAt()->isFuture();
    }

    public function retrieveByVerificationId(string $verificationId): static|null
    {
        return Assert::nullableInstance($this->newQuery()->where('verification_id', $verificationId)->first(), static::class);
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     *
     * @return $this
     */
    public function scopeActive(Builder $builder): static
    {
        $builder->where('verified_at', '<', $this->freshTimestamp())
            ->where('expires_at', '>', $this->freshTimestamp())
            ->where('uses', '>', 0);

        return $this;
    }

    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param iterable<array-key, mixed> $context
     *
     * @return $this
     */
    public function scopeContext(Builder $builder, string $sessionId, iterable $context): static
    {
        $builder->where('session_id', $this->hash($sessionId))
            ->where('context', $this->contextHash($context));

        return $this;
    }

    /**
     * @return $this
     */
    public function setAction(string $action): static
    {
        return $this->fill([
            'action' => $action,
        ]);
    }

    /**
     * @param iterable<array-key, mixed> $context
     *
     * @return $this
     */
    public function setContext(iterable $context): static
    {
        return $this->fill([
            'context' => $this->contextHash($context),
        ]);
    }

    /**
     * @return $this
     */
    public function setDuration(int $duration): static
    {
        return $this->fill([
            'duration' => $duration,
        ]);
    }

    /**
     * @return $this
     */
    public function setExpiresAt(Carbon $expiresAt): static
    {
        return $this->fill([
            'expires_at' => $expiresAt,
        ]);
    }

    public function setPair(string $pair): static
    {
        return $this->fill([
            'pair' => $pair,
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
    public function setSessionId(string $sessionId): static
    {
        return $this->fill([
            'session_id' => $this->hash($sessionId),
        ]);
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
    public function setUses(int $uses): static
    {
        return $this->fill([
            'uses' => $uses,
        ]);
    }

    /**
     * @return $this
     */
    public function setVerificationId(string $verificationId): static
    {
        return $this->fill([
            'verification_id' => $verificationId,
        ]);
    }

    /**
     * @return $this
     */
    public function setVerifiedAt(Carbon|null $verifiedAt): static
    {
        return $this->fill([
            'verified_at' => $verifiedAt,
        ]);
    }

    public function validateToken(string $token): bool
    {
        if (Conf::inject()->isAppEnv(['local', 'testing', 'development']) && \hash_equals($token, \str_repeat($token[0], \mb_strlen($token)))) {
            return true;
        }

        return \hash_equals($this->getToken(), $this->hash($token));
    }
}
