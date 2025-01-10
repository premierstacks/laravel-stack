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

namespace Premierstacks\LaravelStack\Providers;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Auth\Guards\UnlimitedTokenGuard;
use Premierstacks\LaravelStack\Commands\DebugMailCommand;
use Premierstacks\LaravelStack\Commands\MakeEnumCommand;
use Premierstacks\LaravelStack\Commands\ValidityGeneratorCommand;
use Premierstacks\PhpStack\Mixed\Assert;

class LaravelStackServiceProvider extends IlluminateServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslations();
        $this->loadViews();

        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->loadCommands();
    }

    #[\Override]
    public function register(): void
    {
        parent::register();

        $this->registerDatabaseTokenGuard();
        $this->registerValidator();
        $this->registerUserProvider();
    }

    protected function loadCommands(): void
    {
        $this->commands([ValidityGeneratorCommand::class, DebugMailCommand::class, MakeEnumCommand::class]);
    }

    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'psls');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang');
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'psls');
    }

    protected function registerDatabaseTokenGuard(): void
    {
        $this->app->afterResolving(AuthManager::class, static function (AuthManager $authManager): void {
            $authManager->extend(UnlimitedTokenGuard::class, static fn(ApplicationContract $app, string $name, array $config): UnlimitedTokenGuard => UnlimitedTokenGuard::inject(['guardName' => $name, 'config' => $config]));
        });
    }

    protected function registerUserProvider(): void
    {
        if (!$this->app->bound(UserProviderContract::class)) {
            $this->app->bind(UserProviderContract::class, static fn(ApplicationContract $app): UserProviderContract|null => Assert::instance($app->make('auth'), AuthManager::class)->createUserProvider());
        }
    }

    protected function registerValidator(): void
    {
        if (!$this->app->bound(ValidatorContract::class)) {
            $this->app->bind(ValidatorContract::class, static fn(ApplicationContract $app): ValidatorContract => Assert::instance($app->make('validator'), Factory::class)->make(Assert::instance($app->make('request'), Request::class)->all(), []));
        }

        if (!$this->app->bound(Validator::class)) {
            $this->app->bind(Validator::class, static fn(ApplicationContract $app): Validator => Assert::instance($app->make('validator'), \Illuminate\Validation\Factory::class)->make(Assert::instance($app->make('request'), Request::class)->all(), []));
        }
    }
}
