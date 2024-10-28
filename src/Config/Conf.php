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

namespace Premierstacks\LaravelStack\Config;

use Illuminate\Contracts\Config\Repository as ConfigRepositoryContract;
use Illuminate\Foundation\Application;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\Debug\Errorf;
use Premierstacks\PhpStack\Enums\Undefined;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Mixed\Filter;

class Conf
{
    use InjectTrait;

    public function __construct(public ConfigRepositoryContract $config, public Application $app)
    {
        if ($this->app->bound('env') === false) {
            throw new \RuntimeException('Env is not bound in the application container.');
        }
    }

    public function get(string|null $key = null, mixed $default = Undefined::value): mixed
    {
        if ($key === null) {
            return $this->config->all();
        }

        if ($default === Undefined::value && $this->config->has($key) === false) {
            throw new \OutOfRangeException(Errorf::invalidTargetKey($key, $this->config));
        }

        return $this->config->get($key, $default);
    }

    public function getAppCipher(): string
    {
        return Assert::string($this->get('app.cipher'));
    }

    public function getAppDebug(): bool
    {
        return Assert::bool($this->get('app.debug'));
    }

    public function getAppEnv(): string
    {
        return Assert::string($this->app['env']);
    }

    public function getAppFakerLocale(): string
    {
        return Assert::string($this->get('app.faker_locale'));
    }

    public function getAppFallbackLocale(): string
    {
        return Assert::string($this->get('app.fallback_locale'));
    }

    public function getAppKey(): string
    {
        return Assert::string($this->get('app.key'));
    }

    public function getAppLocale(): string
    {
        return Filter::string($this->get('app.locale'));
    }

    /**
     * @return array<array-key, string>
     */
    public function getAppLocales(): array
    {
        return Assert::arrayOf($this->get('app.locales', [$this->getAppLocale()]), static fn(int|string $key, mixed $value): string => Assert::string($value));
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getAppMaintenance(): array
    {
        return Assert::array($this->get('app.maintenance'));
    }

    public function getAppMaintenanceDriver(): string
    {
        return Assert::string($this->get('app.maintenance.driver'));
    }

    public function getAppMaintenanceStore(): string
    {
        return Assert::string($this->get('app.maintenance.store'));
    }

    public function getAppName(): string
    {
        return Assert::string($this->get('app.name'));
    }

    /**
     * @return array<array-key, string>
     */
    public function getAppPreviousKeys(): array
    {
        return Assert::arrayOf($this->get('app.previous_keys'), static fn(int|string $key, mixed $value): string => Assert::string($value));
    }

    public function getAppTimezone(): string
    {
        return Assert::string($this->get('app.timezone'));
    }

    public function getAppUrl(): string
    {
        return Assert::string($this->get('app.url'));
    }

    public function getAuthDefaultsGuard(): string
    {
        return Assert::nonEmptyString($this->get('auth.defaults.guard'));
    }

    public function getAuthDefaultsPasswords(): string
    {
        return Assert::nonEmptyString($this->get('auth.defaults.passwords'));
    }

    public function getAuthDefaultsProvider(): string
    {
        return Assert::nonEmptyString($this->get('auth.defaults.provider'));
    }

    public function getSessionConnection(): string|null
    {
        return Assert::nullableString($this->get('session.connection'));
    }

    public function getSessionCookie(): string
    {
        return Assert::string($this->get('session.cookie'));
    }

    public function getSessionDomain(): string|null
    {
        return Assert::nullableString($this->get('session.domain'));
    }

    public function getSessionDriver(): string
    {
        return Assert::string($this->get('session.driver'));
    }

    public function getSessionEncrypt(): bool
    {
        return Assert::bool($this->get('session.encrypt'));
    }

    public function getSessionExpireOnClose(): bool
    {
        return Assert::bool($this->get('session.expire_on_close'));
    }

    public function getSessionFiles(): string
    {
        return Assert::string($this->get('session.files'));
    }

    public function getSessionHttpOnly(): bool
    {
        return Assert::bool($this->get('session.http_only'));
    }

    public function getSessionLifetime(): int
    {
        return Assert::int($this->get('session.lifetime'));
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getSessionLottery(): array
    {
        return Assert::array($this->get('session.lottery'));
    }

    public function getSessionPartitioned(): bool
    {
        return Assert::bool($this->get('session.partitioned'));
    }

    public function getSessionPath(): string
    {
        return Assert::string($this->get('session.path'));
    }

    public function getSessionSameSite(): string
    {
        return Assert::string($this->get('session.same_site'));
    }

    public function getSessionSecure(): bool
    {
        return Assert::bool($this->get('session.secure'));
    }

    public function getSessionStore(): string|null
    {
        return Assert::nullableString($this->get('session.store'));
    }

    public function getSessionTable(): string
    {
        return Assert::string($this->get('session.table'));
    }

    /**
     * @param array<array-key, string> $envs
     */
    public function isAppEnv(array $envs): bool
    {
        return $this->app->environment($envs) === true;
    }

    /**
     * @template T
     *
     * @param array<string, T> $mapping
     *
     * @return T
     */
    public function mapAppEnv(array $mapping): mixed
    {
        return $mapping[$this->getAppEnv()] ?? throw new \OutOfRangeException(Errorf::invalidTargetKey($this->getAppEnv(), $mapping));
    }

    /**
     * @return $this
     */
    public function set(string $key, mixed $value, bool $replace = true): static
    {
        if ($replace && $this->config->has($key) === false) {
            throw new \OutOfRangeException(Errorf::invalidTargetKey($key, $this->config));
        }

        $this->config->set($key, $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function setAppFallbackLocale(string $locale): static
    {
        $this->app->setFallbackLocale($locale);

        return $this;
    }

    /**
     * @return $this
     */
    public function setAppLocale(string $locale): static
    {
        $this->app->setLocale($locale);

        return $this;
    }

    /**
     * @return $this
     */
    public function setAuthDefaultsGuard(string $guard): static
    {
        return $this->set('auth.defaults.guard', $guard);
    }

    /**
     * @return $this
     */
    public function setAuthDefaultsPasswords(string $passwords): static
    {
        return $this->set('auth.defaults.passwords', $passwords);
    }

    /**
     * @return $this
     */
    public function setAuthDefaultsProvider(string $provider): static
    {
        return $this->set('auth.defaults.provider', $provider);
    }
}
