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

namespace Premierstacks\LaravelStack\Http\Middleware;

use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Premierstacks\LaravelStack\Container\Resolver;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ValidationFactoryMiddleware
{
    public function getContainer(): ContainerContract
    {
        return Resolver::containerContract();
    }

    /**
     * @param \Closure(Request): SymfonyResponse $next
     */
    public function handle(Request $request, \Closure $next, string $concrete): SymfonyResponse
    {
        $this->getContainer()->afterResolving('validator', static function (Factory $factory) use ($concrete): void {
            $factory->resolver(static fn(Translator $translator, array $data, array $rules, array $messages, array $attributes): Validator => Resolver::resolve($concrete, Validator::class, ['translator' => $translator, 'data' => $data, 'rules' => $rules, 'messages' => $messages, 'attributes' => $attributes]));
        });

        return $next($request);
    }
}
