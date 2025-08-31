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

namespace Premierstacks\LaravelStack\Testing;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Premierstacks\PhpStack\Debug\Errorf;
use Premierstacks\PhpStack\Mixed\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait TestCaseTrait
{
    /**
     * @param array<array-key, mixed> $data
     * @param array<array-key, mixed> $headers
     *
     * @return TestResponse<Response>
     */
    public function form(string $method, string $uri, array $data = [], array $headers = []): TestResponse
    {
        $server = $this->transformHeadersToServerVars($headers);
        $cookies = $this->prepareCookiesForRequest();

        return parent::call($method, $uri, $this->formData($data), $cookies, [], $server);
    }

    public function setAuthenticatable(Authenticatable $authenticatable, string|null $guard = null): static
    {
        if ($authenticatable instanceof Model && $authenticatable->wasRecentlyCreated) {
            $authenticatable->wasRecentlyCreated = false;
        }

        Assert::instance($this->app, Application::class);

        $authManager = $this->app->make(AuthManager::class);

        Assert::instance($authManager, AuthManager::class);

        $authManager->guard($guard)->setUser($authenticatable);

        return $this;
    }

    /**
     * @param array<array-key, mixed> $parameters
     *
     * @return array<array-key, mixed>
     */
    protected function formData(array $parameters): array
    {
        foreach ($parameters as $key => $value) {
            if (\is_array($value)) {
                $parameters[$key] = $value === [] ? '' : $this->formData($value);
            } elseif ($value instanceof UploadedFile) {
                continue;
            } elseif (\is_bool($value)) {
                $parameters[$key] = $value === true ? '1' : '0';
            } elseif (\is_string($value)) {
                continue;
            } elseif ($value === null) {
                $parameters[$key] = '';
            } elseif (\is_scalar($value)) {
                $parameters[$key] = (string) $value;
            } elseif ($value instanceof \BackedEnum) {
                $parameters[$key] = $value->value;
            } elseif ($value instanceof \DateTimeInterface) {
                $parameters[$key] = $value->format('Y-m-d\TH:i:s.up');
            } elseif (\is_object($value)) {
                $parameters[$key] = $this->formData(\get_object_vars($value));
            } else {
                throw new \UnexpectedValueException(Errorf::unexpectedValue($value, '?'));
            }
        }

        return $parameters;
    }

    /**
     * @return $this
     */
    protected function setUpCookies(): static
    {
        return $this->withCredentials();
    }

    /**
     * @return $this
     */
    protected function setUpFake(): static
    {
        Storage::fake('public');

        return $this;
    }

    protected function setUpLocale(string $locale): void
    {
        $app = Assert::instance($this->app, Application::class);

        $app->setLocale($locale);
        $app->setFallbackLocale($locale);

        $this->withHeader('Accept-Language', $locale);
        $this->withHeader('Content-Language', $locale);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function providesLocale(): array
    {
        return [
            'en' => ['en'],
            'cs' => ['cs'],
            'sk' => ['sk'],
        ];
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpFake();
        $this->setUpCookies();
    }
}
