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
