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

use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Exceptions\ExceptionHandler;
use Premierstacks\PhpStack\JsonApi\JsonApiError;

class ThrowableJsonApiError extends JsonApiError
{
    use InjectTrait;

    public function __construct(public \Throwable $throwable)
    {
        parent::__construct();
    }

    #[\Override]
    public function getCode(): string|null
    {
        return parent::getCode() ?? $this->getThrowableCode();
    }

    public function getConf(): Conf
    {
        return Conf::inject();
    }

    public function getExceptionHandler(): ExceptionHandler
    {
        return ExceptionHandler::inject();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    #[\Override]
    public function getMeta(): iterable
    {
        yield from parent::getMeta() ?? [];

        yield from $this->getThrowableMeta();
    }

    #[\Override]
    public function getStatus(): string|null
    {
        return parent::getStatus() ?? $this->getThrowableStatus();
    }

    public function getThrowableCode(): string|null
    {
        return (string) $this->getExceptionHandler()->getThrowableCode($this->throwable);
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getThrowableMeta(): iterable
    {
        if ($this->getConf()->getAppDebug()) {
            return ThrowableJsonApiMeta::inject(['throwable' => $this->throwable]);
        }

        yield from [];
    }

    public function getThrowableStatus(): string|null
    {
        return (string) $this->getExceptionHandler()->getThrowableStatusCode($this->throwable);
    }

    public function getThrowableTitle(): string|null
    {
        return $this->getExceptionHandler()->getThrowableTitle($this->throwable);
    }

    #[\Override]
    public function getTitle(): string|null
    {
        return parent::getTitle() ?? $this->getThrowableTitle();
    }
}