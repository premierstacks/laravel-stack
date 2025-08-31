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

namespace Premierstacks\LaravelStack\JsonApi;

use Illuminate\Validation\ValidationException;
use Premierstacks\LaravelStack\Container\Resolve;
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
        return Resolve::inject(JsonApiSource::class, ['pointer' => $this->pointer]);
    }
}
