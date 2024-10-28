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

class ValidationRuleJsonApiError extends ThrowableJsonApiError
{
    public function __construct(public string $attribute, public string $rule, ValidationException $throwable)
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
        return Resolver::inject(JsonApiSource::class, ['pointer' => $this->attribute]);
    }
}
