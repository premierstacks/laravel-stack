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

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\JsonApi\JsonApiErrorInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiErrors;
use Premierstacks\PhpStack\Mixed\Assert;

class ThrowableJsonApiErrors extends JsonApiErrors
{
    use InjectTrait;

    public function __construct(public \Throwable $throwable)
    {
        parent::__construct();
    }

    #[\Override]
    public function getIterator(): \Traversable
    {
        yield from parent::getIterator();

        yield from $this->getThrowableErrors();

        yield from $this->getValidationExceptionErrors();
    }

    /**
     * @return iterable<array-key, JsonApiErrorInterface>
     */
    public function getThrowableErrors(): iterable
    {
        if ($this->throwable instanceof ValidationException) {
            return [];
        }

        yield ThrowableJsonApiError::inject(['throwable' => $this->throwable]);
    }

    /**
     * @return iterable<array-key, JsonApiErrorInterface>
     */
    public function getValidationExceptionErrors(): iterable
    {
        if (!$this->throwable instanceof ValidationException) {
            return [];
        }

        yield ValidationMessageJsonApiError::inject(['pointer' => '/', 'message' => null, 'throwable' => $this->throwable]);

        foreach ($this->throwable->errors() as $attribute => $messages) {
            foreach (Assert::iterable($messages) as $message) {
                yield ValidationMessageJsonApiError::inject(['pointer' => Str::start(\str_replace('.', '/', (string) $attribute), '/'), 'message' => Assert::string($message), 'throwable' => $this->throwable]);
            }
        }

        foreach ($this->throwable->validator->failed() as $attribute => $rules) {
            foreach (Assert::iterable($rules) as $rule => $args) {
                yield ValidationRuleJsonApiError::inject(['pointer' => Str::start(\str_replace('.', '/', (string) $attribute), '/'), 'rule' => (string) $rule, 'throwable' => $this->throwable]);
            }
        }
    }
}
