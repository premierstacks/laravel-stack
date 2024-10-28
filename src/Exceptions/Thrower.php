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

namespace Premierstacks\LaravelStack\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolver;

class Thrower
{
    use InjectTrait;

    public function __construct(public Validator $validator) {}

    /**
     * @return $this
     */
    public function error(string $attribute, string $message): static
    {
        $this->validator->errors()->add($attribute, $message);

        return $this;
    }

    /**
     * @param array<array-key, array-key> $attributes
     *
     * @return $this
     */
    public function errors(array $attributes, string $message): static
    {
        foreach ($attributes as $attribute) {
            $this->error((string) $attribute, $message);
        }

        return $this;
    }

    /**
     * @param array<array-key, mixed> $params
     *
     * @return $this
     */
    public function failure(string $attribute, string $error = 'Invalid', array $params = []): static
    {
        $this->validator->addFailure($attribute, $error, $params);

        return $this;
    }

    /**
     * @param array<array-key, array-key> $attributes
     * @param array<array-key, mixed> $params
     *
     * @return $this
     */
    public function failures(array $attributes, string $error = 'Invalid', array $params = []): static
    {
        foreach ($attributes as $attribute) {
            $this->failure((string) $attribute, $error, $params);
        }

        return $this;
    }

    public function throw(int|null $status = null, string|null $errorBag = null, string|null $redirectTo = null): never
    {
        throw $this->throwable($status, $errorBag, $redirectTo);
    }

    public function throwable(int|null $status = null, string|null $errorBag = null, string|null $redirectTo = null): ValidationException
    {
        $throwable = Resolver::resolve($this->validator->getException(), ValidationException::class, ['validator' => $this->validator]);

        if ($status !== null) {
            $throwable->status($status);
        }

        if ($errorBag !== null) {
            $throwable->errorBag($errorBag);
        }

        if ($redirectTo !== null) {
            $throwable->redirectTo($redirectTo);
        }

        return $throwable;
    }
}
