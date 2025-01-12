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

namespace Premierstacks\LaravelStack\Container;

use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Factory as AuthFactoryContract;
use Illuminate\Contracts\Auth\Guard as GuardContract;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Illuminate\Contracts\Auth\PasswordBrokerFactory as PasswordBrokerFactoryContract;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcherContract;
use Illuminate\Contracts\Bus\QueueingDispatcher as BusQueueingDispatcherContract;
use Illuminate\Contracts\Cache\Factory as CacheFactoryContract;
use Illuminate\Contracts\Cache\Repository as CacheRepositoryContract;
use Illuminate\Contracts\Config\Repository as ConfigRepositoryContract;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieQueueingFactoryContract;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Contracts\Encryption\StringEncrypter as StringEncrypterContract;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcherContract;
use Illuminate\Contracts\Filesystem\Cloud as CloudContract;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactoryContract;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Contracts\Mail\Factory as MailFactoryContract;
use Illuminate\Contracts\Mail\MailQueue as MailQueueContract;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Contracts\Notifications\Dispatcher as NotificationsDispatcherContract;
use Illuminate\Contracts\Notifications\Factory as NotificationsFactoryContract;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Queue\Monitor as QueueMonitorContract;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Contracts\Redis\Connection as RedisConnectionContract;
use Illuminate\Contracts\Redis\Factory as RedisFactoryContract;
use Illuminate\Contracts\Routing\BindingRegistrar as BindingRegistrarContract;
use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryContract;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Illuminate\Cookie\CookieJar;
use Illuminate\Database\Connection as DatabaseConnection;
use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Database\ConnectionResolverInterface as ConnectionResolverContract;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Encryption\Encrypter;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Mix;
use Illuminate\Foundation\Vite;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Client\Factory as HttpClientFactory;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Illuminate\Mail\MailManager;
use Illuminate\Mail\Mailer;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Process\Factory as ProccessFactory;
use Illuminate\Queue\Failed\FailedJobProviderInterface as FailedJobProviderContract;
use Illuminate\Queue\QueueManager;
use Illuminate\Redis\Connections\Connection as RedisConnection;
use Illuminate\Redis\RedisManager;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Support\DateFactory;
use Illuminate\Testing\ParallelTesting;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory as ViewFactory;
use Premierstacks\PhpStack\Mixed\Check;
use Psr\Log\LoggerInterface as LoggerContract;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\HttpKernel;

class Resolve
{
    public static function application(): Application
    {
        return Application::getInstance();
    }

    public static function applicationContract(): ApplicationContract
    {
        return Application::getInstance();
    }

    public static function authFactoryContract(): AuthFactoryContract
    {
        return static::resolve(AuthFactoryContract::class, AuthFactoryContract::class);
    }

    public static function authManager(): AuthManager
    {
        return static::resolve(AuthManager::class, AuthManager::class);
    }

    public static function authenticatableContract(): AuthenticatableContract|null
    {
        return static::nullableResolve(AuthenticatableContract::class, AuthenticatableContract::class);
    }

    public static function bindingRegistrarContract(): BindingRegistrarContract
    {
        return static::resolve(BindingRegistrarContract::class, BindingRegistrarContract::class);
    }

    public static function bladeCompiler(): BladeCompiler
    {
        return static::resolve(BladeCompiler::class, BladeCompiler::class);
    }

    public static function broadcastManager(): BroadcastManager
    {
        return static::resolve(BroadcastManager::class, BroadcastManager::class);
    }

    public static function broadcastingFactory(): BroadcastingFactoryContract
    {
        return static::resolve(BroadcastingFactoryContract::class, BroadcastingFactoryContract::class);
    }

    public static function busDispatcherContract(): BusDispatcherContract
    {
        return static::resolve(BusDispatcherContract::class, BusDispatcherContract::class);
    }

    public static function busQueueingDispatcherContract(): BusQueueingDispatcherContract
    {
        return static::resolve(BusQueueingDispatcherContract::class, BusQueueingDispatcherContract::class);
    }

    public static function cacheFactoryContract(): CacheFactoryContract
    {
        return static::resolve(CacheFactoryContract::class, CacheFactoryContract::class);
    }

    public static function cacheManager(): CacheManager
    {
        return static::resolve(CacheManager::class, CacheManager::class);
    }

    public static function cacheRepository(): CacheRepository
    {
        return static::resolve(CacheRepository::class, CacheRepository::class);
    }

    public static function cacheRepositoryContract(): CacheRepositoryContract
    {
        return static::resolve(CacheRepositoryContract::class, CacheRepositoryContract::class);
    }

    public static function channelManager(): ChannelManager
    {
        return static::resolve(ChannelManager::class, ChannelManager::class);
    }

    public static function cloudContract(): CloudContract
    {
        return static::resolve(CloudContract::class, CloudContract::class);
    }

    public static function configRepository(): ConfigRepository
    {
        return static::resolve(ConfigRepository::class, ConfigRepository::class);
    }

    public static function configRepositoryContract(): ConfigRepositoryContract
    {
        return static::resolve(ConfigRepositoryContract::class, ConfigRepositoryContract::class);
    }

    public static function connectionResolverContract(): ConnectionResolverContract
    {
        return static::resolve(ConnectionResolverContract::class, ConnectionResolverContract::class);
    }

    public static function consoleKernel(): ConsoleKernel
    {
        return static::resolve(ConsoleKernelContract::class, ConsoleKernel::class);
    }

    public static function consoleKernelContract(): ConsoleKernelContract
    {
        return static::resolve(ConsoleKernelContract::class, ConsoleKernelContract::class);
    }

    public static function container(): Container
    {
        return Container::getInstance();
    }

    public static function containerContract(): ContainerContract
    {
        return Container::getInstance();
    }

    public static function cookieFactory(): CookieFactory
    {
        return static::resolve(CookieFactory::class, CookieFactory::class);
    }

    public static function cookieJar(): CookieJar
    {
        return static::resolve(CookieJar::class, CookieJar::class);
    }

    public static function cookieQueueingFactoryContract(): CookieQueueingFactoryContract
    {
        return static::resolve(CookieQueueingFactoryContract::class, CookieQueueingFactoryContract::class);
    }

    public static function databaseConnection(): DatabaseConnection
    {
        return static::resolve(DatabaseConnection::class, DatabaseConnection::class);
    }

    public static function databaseConnectionContract(): DatabaseConnectionContract
    {
        return static::resolve(DatabaseConnectionContract::class, DatabaseConnectionContract::class);
    }

    public static function databaseManager(): DatabaseManager
    {
        return static::resolve(DatabaseManager::class, DatabaseManager::class);
    }

    public static function dateFactory(): DateFactory
    {
        return static::resolve(DateFactory::class, DateFactory::class);
    }

    public static function encrypter(): Encrypter
    {
        return static::resolve(Encrypter::class, Encrypter::class);
    }

    public static function encrypterContract(): EncrypterContract
    {
        return static::resolve(EncrypterContract::class, EncrypterContract::class);
    }

    public static function eventDispatcher(): EventDispatcher
    {
        return static::resolve(EventDispatcher::class, EventDispatcher::class);
    }

    public static function eventDispatcherContract(): EventsDispatcherContract
    {
        return static::resolve(EventsDispatcherContract::class, EventsDispatcherContract::class);
    }

    public static function exceptionHandler(): ExceptionHandler
    {
        return static::resolve(ExceptionHandlerContract::class, ExceptionHandler::class);
    }

    public static function exceptionHandlerContract(): ExceptionHandlerContract
    {
        return static::resolve(ExceptionHandlerContract::class, ExceptionHandlerContract::class);
    }

    public static function failedJobProviderContract(): FailedJobProviderContract
    {
        return static::resolve(FailedJobProviderContract::class, FailedJobProviderContract::class);
    }

    public static function filesystem(): Filesystem
    {
        return static::resolve(Filesystem::class, Filesystem::class);
    }

    public static function filesystemContract(): FilesystemContract
    {
        return static::resolve(FilesystemContract::class, FilesystemContract::class);
    }

    public static function filesystemFactoryContract(): FilesystemFactoryContract
    {
        return static::resolve(FilesystemFactoryContract::class, FilesystemFactoryContract::class);
    }

    public static function filesystemManager(): FilesystemManager
    {
        return static::resolve(FilesystemManager::class, FilesystemManager::class);
    }

    public static function gate(): Gate
    {
        return static::resolve(GateContract::class, Gate::class);
    }

    public static function gateContract(): GateContract
    {
        return static::resolve(GateContract::class, GateContract::class);
    }

    public static function guardContract(): GuardContract
    {
        return static::resolve(GuardContract::class, GuardContract::class);
    }

    public static function hashManager(): HashManager
    {
        return static::resolve(HashManager::class, HashManager::class);
    }

    public static function hasherContract(): HasherContract
    {
        return static::resolve(HasherContract::class, HasherContract::class);
    }

    public static function httpClientFactory(): HttpClientFactory
    {
        return static::resolve(HttpClientFactory::class, HttpClientFactory::class);
    }

    public static function httpKernel(): HttpKernel
    {
        return static::resolve(HttpKernelContract::class, HttpKernel::class);
    }

    public static function httpKernelContract(): HttpKernelContract
    {
        return static::resolve(HttpKernelContract::class, HttpKernelContract::class);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $abstract
     * @param array<string, mixed> $parameters
     *
     * @return T
     */
    public static function inject(string $abstract, array $parameters = []): object
    {
        return Check::instance(Container::getInstance()->make($abstract, $parameters), $abstract);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $abstract
     * @param array<string, mixed> $parameters
     *
     * @return T
     */
    public static function instance(string $abstract, array $parameters = []): object
    {
        return Check::instance(Container::getInstance()->make($abstract, $parameters), $abstract);
    }

    public static function logManager(): LogManager
    {
        return static::resolve(LogManager::class, LogManager::class);
    }

    public static function loggerContract(): LoggerContract
    {
        return static::resolve(LoggerContract::class, LoggerContract::class);
    }

    public static function mailFactoryContract(): MailFactoryContract
    {
        return static::resolve(MailFactoryContract::class, MailFactoryContract::class);
    }

    public static function mailManager(): MailManager
    {
        return static::resolve(MailManager::class, MailManager::class);
    }

    public static function mailQueueContract(): MailQueueContract
    {
        return static::resolve(MailQueueContract::class, MailQueueContract::class);
    }

    public static function mailer(): Mailer
    {
        return static::resolve(Mailer::class, Mailer::class);
    }

    public static function mailerContract(): MailerContract
    {
        return static::resolve(MailerContract::class, MailerContract::class);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public static function make(string $abstract, array $parameters = []): mixed
    {
        return Container::getInstance()->make($abstract, $parameters);
    }

    public static function mix(): Mix
    {
        return static::resolve(Mix::class, Mix::class);
    }

    public static function notificationsDispatcherContract(): NotificationsDispatcherContract
    {
        return static::resolve(NotificationsDispatcherContract::class, NotificationsDispatcherContract::class);
    }

    public static function notificationsFactoryContract(): NotificationsFactoryContract
    {
        return static::resolve(NotificationsFactoryContract::class, NotificationsFactoryContract::class);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     * @param array<array-key, string> $parameters
     *
     * @return T
     */
    public static function nullableResolve(string $abstract, string $class, array $parameters = []): object|null
    {
        return Check::nullableInstance(Container::getInstance()->make($abstract, $parameters), $class);
    }

    public static function parallelTesting(): ParallelTesting
    {
        return static::resolve(ParallelTesting::class, ParallelTesting::class);
    }

    public static function passwordBroker(): PasswordBroker
    {
        return static::resolve(PasswordBroker::class, PasswordBroker::class);
    }

    public static function passwordBrokerContract(): PasswordBrokerContract
    {
        return static::resolve(PasswordBrokerContract::class, PasswordBrokerContract::class);
    }

    public static function passwordBrokerFactoryContract(): PasswordBrokerFactoryContract
    {
        return static::resolve(PasswordBrokerFactoryContract::class, PasswordBrokerFactoryContract::class);
    }

    public static function passwordBrokerManager(): PasswordBrokerManager
    {
        return static::resolve(PasswordBrokerManager::class, PasswordBrokerManager::class);
    }

    public static function processFactory(): ProccessFactory
    {
        return static::resolve(ProccessFactory::class, ProccessFactory::class);
    }

    public static function queueContract(): QueueContract
    {
        return static::resolve(QueueContract::class, QueueContract::class);
    }

    public static function queueFactoryContract(): QueueFactoryContract
    {
        return static::resolve(QueueFactoryContract::class, QueueFactoryContract::class);
    }

    public static function queueManager(): QueueManager
    {
        return static::resolve(QueueManager::class, QueueManager::class);
    }

    public static function queueMonitorContract(): QueueMonitorContract
    {
        return static::resolve(QueueMonitorContract::class, QueueMonitorContract::class);
    }

    public static function rateLimiter(): RateLimiter
    {
        return static::resolve(RateLimiter::class, RateLimiter::class);
    }

    public static function redirector(): Redirector
    {
        return static::resolve(Redirector::class, Redirector::class);
    }

    public static function redisConnection(): RedisConnection
    {
        return static::resolve(RedisConnection::class, RedisConnection::class);
    }

    public static function redisConnectionContract(): RedisConnectionContract
    {
        return static::resolve(RedisConnectionContract::class, RedisConnectionContract::class);
    }

    public static function redisFactoryContract(): RedisFactoryContract
    {
        return static::resolve(RedisFactoryContract::class, RedisFactoryContract::class);
    }

    public static function redisManager(): RedisManager
    {
        return static::resolve(RedisManager::class, RedisManager::class);
    }

    public static function registrarContract(): RegistrarContract
    {
        return static::resolve(RegistrarContract::class, RegistrarContract::class);
    }

    public static function request(): Request
    {
        return static::resolve(Request::class, Request::class);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     * @param array<string, mixed> $parameters
     *
     * @return T
     */
    public static function resolve(string $abstract, string $class, array $parameters = []): object
    {
        return Check::instance(Container::getInstance()->make($abstract, $parameters), $class);
    }

    public static function responseFactoryContract(): ResponseFactoryContract
    {
        return static::resolve(ResponseFactoryContract::class, ResponseFactoryContract::class);
    }

    public static function routeRegistrar(): RouteRegistrar
    {
        return static::resolve(RouteRegistrar::class, RouteRegistrar::class);
    }

    public static function router(): Router
    {
        return static::resolve(Router::class, Router::class);
    }

    public static function schemaBuilder(): SchemaBuilder
    {
        return static::resolve(SchemaBuilder::class, SchemaBuilder::class);
    }

    public static function sessionContract(): SessionContract
    {
        return static::resolve(SessionContract::class, SessionContract::class);
    }

    public static function sessionManager(): SessionManager
    {
        return static::resolve(SessionManager::class, SessionManager::class);
    }

    public static function sessionStore(): SessionStore
    {
        return static::resolve(SessionStore::class, SessionStore::class);
    }

    public static function stringEncrypterContract(): StringEncrypterContract
    {
        return static::resolve(StringEncrypterContract::class, StringEncrypterContract::class);
    }

    public static function symfonyRequest(): SymfonyRequest
    {
        return static::resolve(SymfonyRequest::class, SymfonyRequest::class);
    }

    public static function translator(): Translator
    {
        return static::resolve(Translator::class, Translator::class);
    }

    public static function translatorContract(): TranslatorContract
    {
        return static::resolve(TranslatorContract::class, TranslatorContract::class);
    }

    public static function urlGenerator(): UrlGenerator
    {
        return static::resolve(UrlGenerator::class, UrlGenerator::class);
    }

    public static function urlGeneratorContract(): UrlGeneratorContract
    {
        return static::resolve(UrlGeneratorContract::class, UrlGeneratorContract::class);
    }

    public static function userProviderContract(): UserProviderContract
    {
        return static::resolve(UserProviderContract::class, UserProviderContract::class);
    }

    public static function validationFactory(): ValidationFactory
    {
        return static::resolve(ValidationFactory::class, ValidationFactory::class);
    }

    public static function validationFactoryContract(): ValidationFactoryContract
    {
        return static::resolve(ValidationFactoryContract::class, ValidationFactoryContract::class);
    }

    public static function viewFactory(): ViewFactory
    {
        return static::resolve(ViewFactory::class, ViewFactory::class);
    }

    public static function viewFactoryContract(): ViewFactoryContract
    {
        return static::resolve(ViewFactoryContract::class, ViewFactoryContract::class);
    }

    public static function vite(): Vite
    {
        return static::resolve(Vite::class, Vite::class);
    }
}
