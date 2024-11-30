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

namespace Premierstacks\LaravelStack\Auth\Guards;

use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Guard as GuardContract;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieQueueingFactoryContract;
use Illuminate\Http\Request;
use Premierstacks\LaravelStack\Auth\Models\UnlimitedToken;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\PhpStack\Mixed\Assert;
use Premierstacks\PhpStack\Types\Strings;

class UnlimitedTokenGuard implements GuardContract
{
    use InjectTrait;

    public AuthenticatableContract|false|null $authenticatable = null;

    public UnlimitedToken|false|null $unlimitedToken = null;

    /**
     * @param array<array-key, mixed> $config
     */
    public function __construct(
        public string $guardName,
        public array $config,
    ) {}

    public function authorize(AuthenticatableContract $authenticatable): Response
    {
        $config = $this->getConfig();

        $ability = \array_key_exists('ability', $config) ? $config['ability'] : true;

        if (\is_bool($ability)) {
            return $ability ? Response::allow() : Response::deny();
        }

        $ability = Assert::string($ability);
        $gate = $this->getGate()->forUser(null);

        return $gate->inspect($ability, $authenticatable);
    }

    #[\Override]
    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function createUnlimitedToken(AuthenticatableContract $authenticatable): UnlimitedToken
    {
        $unlimitedToken = $this->newUnlimitedToken()
            ->setAuthenticatable($authenticatable)
            ->setUnlimitedTokenGuard($this)
            ->generateToken();

        $unlimitedToken->mustSave();

        return $unlimitedToken;
    }

    public function dequeue(): void
    {
        $this->queueCookie($this->getCookieName(), '', -2_628_000);
    }

    public function getAuthManager(): AuthManager
    {
        return Resolver::authManager();
    }

    public function getConf(): Conf
    {
        return Conf::inject();
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function getCookieDomain(): string|null
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_domain', $config)) {
            return Assert::nullableString($config['cookie_domain']);
        }

        return $this->getConf()->getSessionDomain();
    }

    public function getCookieHttpOnly(): bool
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_http_only', $config)) {
            return Assert::bool($config['cookie_http_only']);
        }

        return $this->getConf()->getSessionHttpOnly();
    }

    public function getCookieMinutes(): int
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_minutes', $config)) {
            return Assert::int($config['cookie_minutes']);
        }

        return 2_628_000;
    }

    public function getCookieName(): string
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_name', $config)) {
            return Assert::string($config['cookie_name']);
        }

        return $this->getConf()->getSessionCookie() . "-authorization-{$this->getGuardName()}";
    }

    public function getCookiePath(): string|null
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_path', $config)) {
            return Assert::nullableString($config['cookie_path']);
        }

        return $this->getConf()->getSessionPath();
    }

    public function getCookieSameSite(): string
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_same_site', $config)) {
            return Assert::string($config['cookie_same_site']);
        }

        return $this->getConf()->getSessionSameSite();
    }

    public function getCookieSecure(): bool|null
    {
        $config = $this->getConfig();

        if (\array_key_exists('cookie_secure', $config)) {
            return Assert::nullableBool($config['cookie_secure']);
        }

        return $this->getConf()->getSessionSecure();
    }

    public function getCookies(): CookieQueueingFactoryContract
    {
        return Resolver::cookieQueueingFactoryContract();
    }

    public function getGate(): Gate
    {
        return Resolver::gate();
    }

    public function getGuardName(): string
    {
        return $this->guardName;
    }

    public function getRequest(): Request
    {
        return Resolver::request();
    }

    public function getUnlimitedToken(): UnlimitedToken|null
    {
        if ($this->unlimitedToken instanceof UnlimitedToken) {
            return $this->unlimitedToken;
        }

        if ($this->unlimitedToken === false) {
            return null;
        }

        $this->parse();

        if ($this->unlimitedToken instanceof UnlimitedToken) {
            return $this->unlimitedToken;
        }

        return null;
    }

    public function getUserProvider(): UserProviderContract
    {
        $userProvider = $this->getAuthManager()->createUserProvider($this->getUserProviderName());

        if ($userProvider === null) {
            throw new \UnexpectedValueException('Could not create the user provider.');
        }

        return $userProvider;
    }

    public function getUserProviderName(): string
    {
        $config = $this->getConfig();

        if (\array_key_exists('provider', $config)) {
            return Assert::string($config['provider']);
        }

        return $this->getGuardName();
    }

    #[\Override]
    public function guest(): bool
    {
        return $this->check() === false;
    }

    #[\Override]
    public function hasUser(): bool
    {
        return $this->authenticatable instanceof AuthenticatableContract;
    }

    #[\Override]
    public function id(): int|string|null
    {
        $user = $this->user();

        if ($user === null) {
            return null;
        }

        return Assert::arrayKey($user->getAuthIdentifier());
    }

    public function loadUnlimitedToken(UnlimitedToken $unlimitedToken): bool
    {
        if ($unlimitedToken->isActive() !== true) {
            return false;
        }

        if ($unlimitedToken->getGuardName() !== $this->getGuardName()) {
            return false;
        }

        if ($unlimitedToken->getUserProviderName() !== $this->getUserProviderName()) {
            return false;
        }

        $authenticatable = $this->retrieveAuthenticatable($unlimitedToken);

        if ($authenticatable === null) {
            return false;
        }

        $this->setUser($authenticatable);
        $this->setUnlimitedToken($unlimitedToken);

        return true;
    }

    public function loadUnlimitedTokenFromBearerToken(string $bearerToken): bool
    {
        $unlimitedToken = $this->retrieveUnlimitedTokenByBearerToken($bearerToken);

        if ($unlimitedToken === null) {
            return false;
        }

        return $this->loadUnlimitedToken($unlimitedToken);
    }

    public function login(AuthenticatableContract $authenticatable): void
    {
        $loaded = $this->loadUnlimitedToken($this->createUnlimitedToken($authenticatable));

        if (!$loaded) {
            throw new \LogicException('Failed to load the unlimited token.');
        }

        $this->queue();
    }

    public function logoutAllDevices(): void
    {
        $authenticatable = $this->user();

        $this->logoutCurrentDevice();

        if ($authenticatable === null) {
            return;
        }

        $this->newUnlimitedToken()
            ->setUnlimitedTokenGuard($this)
            ->setAuthenticatable($authenticatable)
            ->revokeAllDevices();
    }

    public function logoutCurrentDevice(): void
    {
        $unlimitedToken = $this->getUnlimitedToken();

        if ($unlimitedToken !== null) {
            $unlimitedToken->asRevoked()->mustSave();
        }

        $this->authenticatable = false;
        $this->unlimitedToken = false;

        $this->dequeue();
    }

    public function logoutOtherDevices(): void
    {
        $authenticatable = $this->user();
        $unlimitedToken = $this->getUnlimitedToken();

        if ($authenticatable === null) {
            return;
        }

        if ($unlimitedToken === null) {
            $this->newUnlimitedToken()
                ->setUnlimitedTokenGuard($this)
                ->setAuthenticatable($authenticatable)
                ->revokeAllDevices();
        } else {
            $unlimitedToken->syncAuthenticatable($authenticatable);
            $unlimitedToken->revokeOtherDevices();
        }
    }

    public function newUnlimitedToken(): UnlimitedToken
    {
        $config = $this->getConfig();

        if (\array_key_exists('unlimited_token', $config)) {
            return Resolver::resolve(Assert::string($config['unlimited_token']), UnlimitedToken::class);
        }

        return UnlimitedToken::inject();
    }

    public function parse(): void
    {
        $request = $this->getRequest();

        $header = $request->bearerToken();

        if ($header !== null) {
            if ($this->loadUnlimitedTokenFromBearerToken($header)) {
                return;
            }
        }

        $cookie = $request->cookies->get($this->getCookieName());

        if ($cookie !== null) {
            $this->loadUnlimitedTokenFromBearerToken((string) $cookie);
        }
    }

    public function queue(): void
    {
        $unlimitedToken = $this->getUnlimitedToken();

        if ($unlimitedToken === null || $unlimitedToken->getBearerToken() === null) {
            return;
        }

        $this->queueCookie($this->getCookieName(), $unlimitedToken->getBearerToken(), $this->getCookieMinutes());
    }

    public function queueCookie(string $name, string $value, int $minutes): void
    {
        $cookies = $this->getCookies();

        $cookies->queue(
            $cookies->make(
                $name,
                $value,
                $minutes,
                $this->getCookiePath(),
                $this->getCookieDomain(),
                $this->getCookieSecure(),
                $this->getCookieHttpOnly(),
                false,
                $this->getCookieSameSite(),
            ),
        );
    }

    public function retrieveAuthenticatable(UnlimitedToken $unlimitedToken): AuthenticatableContract|null
    {
        $authenticatable = $this->getUserProvider()->retrieveById($unlimitedToken->getAuthenticatableId());

        if ($authenticatable === null) {
            return null;
        }

        if ($this->authorize($authenticatable)->denied()) {
            return null;
        }

        if (!\hash_equals(Strings::nullify($authenticatable->getAuthPassword(), false) ?? '', $unlimitedToken->getPassword() ?? '')) {
            return null;
        }

        return $authenticatable;
    }

    public function retrieveUnlimitedTokenByBearerToken(string $bearerToken): UnlimitedToken|null
    {
        return $this->newUnlimitedToken()
            ->setUnlimitedTokenGuard($this)
            ->retrieveByBearerToken($bearerToken);
    }

    public function setUnlimitedToken(UnlimitedToken $unlimitedToken): static
    {
        $this->unlimitedToken = $unlimitedToken;

        return $this;
    }

    #[\Override]
    public function setUser(AuthenticatableContract $user): static
    {
        $this->authenticatable = $user;

        return $this;
    }

    #[\Override]
    public function user(): AuthenticatableContract|null
    {
        if ($this->authenticatable instanceof AuthenticatableContract) {
            return $this->authenticatable;
        }

        if ($this->authenticatable === false) {
            return null;
        }

        $this->parse();

        if ($this->authenticatable instanceof AuthenticatableContract) {
            return $this->authenticatable;
        }

        return null;
    }

    /**
     * @param array<array-key, mixed> $credentials
     */
    #[\Override]
    public function validate(array $credentials = []): bool
    {
        $provider = $this->getUserProvider();

        $auth = $provider->retrieveByCredentials($credentials);

        if ($auth === null) {
            return false;
        }

        return $provider->validateCredentials($auth, $credentials);
    }
}
