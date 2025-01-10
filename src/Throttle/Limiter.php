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

namespace Premierstacks\LaravelStack\Throttle;

use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit as IlluminateLimit;
use Illuminate\Http\Exceptions\HttpResponseException;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\PhpStack\Mixed\Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Limiter
{
    use InjectTrait;

    public function __construct(public IlluminateLimit $limit) {}

    /**
     * @param \Closure(): Response|\Closure(): never|\Closure(int): Response|\Closure(int): never|null $callback
     *
     * @return $this
     */
    public function authorize(\Closure|null $callback = null): static
    {
        if ($this->tooManyAttempts()) {
            $this->throw($callback);
        }

        return $this;
    }

    public function availableIn(): int
    {
        return $this->getLimiter()->availableIn($this->cacheKey());
    }

    public function cacheKey(): string
    {
        if (\is_scalar($this->limit->key)) {
            return self::class . ':' . (string) $this->limit->key;
        }

        return self::class;
    }

    /**
     * @template T
     *
     * @param \Closure(): T $try
     * @param \Closure(): void|\Closure(\Throwable): void|null $catch
     * @param \Closure(): void|null $finally
     *
     * @return T
     */
    public function catch(\Closure $try, \Closure|null $catch = null, \Closure|null $finally = null): mixed
    {
        try {
            return $try();
        } catch (\Throwable $e) {
            $this->hit();

            $catch?->__invoke($e);

            throw $e;
        } finally {
            $finally?->__invoke();
        }
    }

    /**
     * @return $this
     */
    public function clear(): static
    {
        $this->getLimiter()->clear($this->cacheKey());

        return $this;
    }

    /**
     * @template T
     *
     * @param \Closure(): T $try
     * @param \Closure(): void|\Closure(\Throwable): void|null $catch
     * @param \Closure(): void|null $finally
     *
     * @return T
     */
    public function finally(\Closure $try, \Closure|null $catch = null, \Closure|null $finally = null): mixed
    {
        try {
            return $try();
        } catch (\Throwable $e) {
            $catch?->__invoke($e);

            throw $e;
        } finally {
            $this->hit();

            $finally?->__invoke();
        }
    }

    public function getLimiter(): RateLimiter
    {
        return \once(static fn(): RateLimiter => Resolver::rateLimiter());
    }

    /**
     * @return $this
     */
    public function hit(): static
    {
        $this->getLimiter()->hit($this->cacheKey(), $this->limit->decaySeconds);

        return $this;
    }

    /**
     * @return $this
     */
    public function setLimit(IlluminateLimit $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @template T
     *
     * @param \Closure(): T $try
     * @param \Closure(): void|\Closure(\Throwable): void|null $catch
     * @param \Closure(): void|null $finally
     * @param 'catch'|'finally'|'off'|'try' $mode
     *
     * @return T
     */
    public function throttle(\Closure $try, \Closure|null $catch = null, \Closure|null $finally = null, string $mode = 'off'): mixed
    {
        if ($mode === 'try') {
            return $this->try($try, $catch, $finally);
        }

        if ($mode === 'catch') {
            return $this->catch($try, $catch, $finally);
        }

        if ($mode === 'finally') {
            return $this->finally($try, $catch, $finally);
        }

        return $try();
    }

    /**
     * @param \Closure(): Response|\Closure(): never|\Closure(int): Response|\Closure(int): never|null $callback
     */
    public function throw(\Closure|null $callback = null): never
    {
        $in = $this->availableIn();

        if ($callback !== null) {
            throw new HttpResponseException($callback($in));
        }

        if (isset($this->limit->responseCallback)) {
            throw new HttpResponseException(Assert::instance(($this->limit->responseCallback)(), Response::class, '$this->limit->responseCallback'));
        }

        throw new TooManyRequestsHttpException($in);
    }

    public function tooManyAttempts(): bool
    {
        return $this->getLimiter()->tooManyAttempts($this->cacheKey(), $this->limit->maxAttempts);
    }

    /**
     * @template T
     *
     * @param \Closure(): T $try
     * @param \Closure(): void|\Closure(\Throwable): void|null $catch
     * @param \Closure(): void|null $finally
     *
     * @return T
     */
    public function try(\Closure $try, \Closure|null $catch = null, \Closure|null $finally = null): mixed
    {
        try {
            $returned = $try();

            $this->hit();

            return $returned;
        } catch (\Throwable $e) {
            $catch?->__invoke($e);

            throw $e;
        } finally {
            $finally?->__invoke();
        }
    }

    public static function dependency(IlluminateLimit $limit): static
    {
        return static::inject(['limit' => $limit]);
    }
}
