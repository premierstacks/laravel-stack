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

namespace Premierstacks\LaravelStack\Validation\Validators;

class ApiValidator extends Validator
{
    #[\Override]
    public function getDisplayableAttribute(mixed $attribute): string
    {
        return "{{{$attribute}}}";
    }

    #[\Override]
    public function getDisplayableValue(mixed $attribute, mixed $value): string
    {
        return "[[{$attribute}]]";
    }

    /**
     * @param array<array-key, mixed> $parameters
     */
    #[\Override]
    public function makeReplacements(mixed $message, mixed $attribute, mixed $rule, mixed $parameters): string
    {
        foreach ($parameters as $key => $value) {
            $message = \str_replace(":{$key}", "[{$key}]", $message);
        }

        return parent::makeReplacements($message, $attribute, $rule, $parameters);
    }

    #[\Override]
    protected function replaceAttributePlaceholder(mixed $message, mixed $value): string
    {
        return \str_replace([':attribute', ':ATTRIBUTE', ':Attribute'], '{{}}', $message);
    }
}
