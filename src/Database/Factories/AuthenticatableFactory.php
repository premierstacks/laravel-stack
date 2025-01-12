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

namespace Premierstacks\LaravelStack\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Container\Resolve;

/**
 * @template T of Model
 *
 * @extends Factory<T>
 */
class AuthenticatableFactory extends Factory
{
    public static string $password = 'password';

    #[\Override]
    public function definition(): array
    {
        $attributes = [];

        $instance = $this->newModel();

        $keys = \array_keys($instance->getAttributes());

        if (\in_array('name', $keys, true)) {
            $attributes['name'] = \fake()->name();
        }

        if (\in_array('email', $keys, true)) {
            $attributes['email'] = \fake()
                ->unique()
                ->email();
        }

        if (\in_array('email_verified_at', $keys, true)) {
            $attributes['email_verified_at'] = $instance->freshTimestamp();
        }

        if (\in_array('email_to_verify', $keys, true)) {
            $attributes['email_to_verify'] = static fn(array $attributes): mixed => $attributes['email'] ?? null;
        }

        if (\in_array('email_for_verification', $keys, true)) {
            $attributes['email_for_verification'] = static fn(array $attributes): mixed => $attributes['email'] ?? null;
        }

        if (\in_array('password', $keys, true)) {
            $attributes['password'] = static::$password;
        }

        if (\in_array('remember_token', $keys, true)) {
            $attributes['remember_token'] = Str::random(10);
        }

        if (\in_array('locale', $keys, true)) {
            $attributes['locale'] = \fake()->randomElement(Resolve::resolve(Conf::class, Conf::class)->getAppLocales());
        }

        if (\in_array('first_name', $keys, true)) {
            $attributes['first_name'] = \fake()->firstName();
        }

        if (\in_array('firstname', $keys, true)) {
            $attributes['firstname'] = \fake()->firstName();
        }

        if (\in_array('last_name', $keys, true)) {
            $attributes['last_name'] = \fake()->lastName();
        }

        if (\in_array('lastname', $keys, true)) {
            $attributes['lastname'] = \fake()->lastName();
        }

        if (\in_array('username', $keys, true)) {
            $attributes['username'] = \fake()->userName();
        }

        if (\in_array('user_name', $keys, true)) {
            $attributes['user_name'] = \fake()->userName();
        }

        if (\in_array('full_name', $keys, true)) {
            $attributes['full_name'] = \fake()->name();
        }

        if (\in_array('fullname', $keys, true)) {
            $attributes['fullname'] = \fake()->name();
        }

        if (\in_array('phone', $keys, true)) {
            $attributes['phone'] = \fake()->e164PhoneNumber();
        }

        if (\in_array('phone_number', $keys, true)) {
            $attributes['phone_number'] = \fake()->e164PhoneNumber();
        }

        if (\in_array('phonenumber', $keys, true)) {
            $attributes['phonenumber'] = \fake()->e164PhoneNumber();
        }

        return $attributes;
    }
}
