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

namespace Premierstacks\LaravelStack\JsonApi;

use Illuminate\Validation\ValidationException;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\PhpStack\JsonApi\JsonApiSource;
use Premierstacks\PhpStack\JsonApi\JsonApiSourceInterface;

class ValidationMessageJsonApiError extends ThrowableJsonApiError
{
    public function __construct(public string $pointer, public string|null $message, ValidationException $throwable)
    {
        parent::__construct($throwable);
    }

    #[\Override]
    public function getDetail(): string|null
    {
        return parent::getDetail() ?? $this->message;
    }

    #[\Override]
    public function getSource(): JsonApiSourceInterface|null
    {
        return parent::getSource() ?? $this->getValidationExceptionSource();
    }

    #[\Override]
    public function getThrowableMeta(): iterable
    {
        yield from [];
    }

    public function getValidationExceptionSource(): JsonApiSourceInterface|null
    {
        return Resolver::inject(JsonApiSource::class, ['pointer' => $this->pointer]);
    }
}
