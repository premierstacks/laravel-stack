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

namespace Premierstacks\LaravelStack\JsonApi;

use Illuminate\Validation\ValidationException;
use Premierstacks\LaravelStack\Container\Resolve;
use Premierstacks\PhpStack\JsonApi\JsonApiSource;
use Premierstacks\PhpStack\JsonApi\JsonApiSourceInterface;

class ValidationRuleJsonApiError extends ThrowableJsonApiError
{
    public function __construct(public string $pointer, public string $rule, ValidationException $throwable)
    {
        parent::__construct($throwable);
    }

    /**
     * @return iterable<array-key, mixed>
     */
    #[\Override]
    public function getMeta(): iterable
    {
        yield from parent::getMeta();

        yield from $this->getValidationExceptionMeta();
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

    /**
     * @return iterable<array-key, mixed>
     */
    public function getValidationExceptionMeta(): iterable
    {
        yield 'rule' => [
            'name' => $this->rule,
        ];
    }

    public function getValidationExceptionSource(): JsonApiSourceInterface|null
    {
        return Resolve::inject(JsonApiSource::class, ['pointer' => $this->pointer]);
    }
}
