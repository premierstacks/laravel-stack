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

return [
    'accepted' => 'This field must be accepted.',
    'accepted_if' => 'This field must meet certain conditions to be accepted.',
    'active_url' => 'This field must be a valid URL.',
    'after' => 'This field must be a date after a specific date.',
    'after_or_equal' => 'This field must be a date after or equal to a specific date.',
    'alpha' => 'This field must only contain letters.',
    'alpha_dash' => 'This field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'This field must only contain letters and numbers.',
    'array' => 'This field must be an array.',
    'ascii' => 'This field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'This field must be a date before a specific date.',
    'before_or_equal' => 'This field must be a date before or equal to a specific date.',
    'between' => [
        'array' => 'This field must have a specific range of items.',
        'file' => 'This field must be within a specific size range.',
        'numeric' => 'This field must be within a specific range.',
        'string' => 'This field must have a specific range of characters.',
    ],
    'boolean' => 'This field must be true or false.',
    'can' => 'This field contains an unauthorized value.',
    'confirmed' => 'This field confirmation does not match.',
    'current_password' => 'This password is incorrect.',
    'date' => 'This field must be a valid date.',
    'date_equals' => 'This field must match a specific date.',
    'date_format' => 'This field must match a specific format.',
    'decimal' => 'This field must have a certain number of decimal places.',
    'declined' => 'This field must be declined.',
    'declined_if' => 'This field must be declined under certain conditions.',
    'different' => 'This field must be different from another field.',
    'digits' => 'This field must have a specific number of digits.',
    'digits_between' => 'This field must have digits within a certain range.',
    'dimensions' => 'This field has invalid image dimensions.',
    'distinct' => 'This field has a duplicate value.',
    'doesnt_end_with' => 'This field must not end with specific values.',
    'doesnt_start_with' => 'This field must not start with specific values.',
    'email' => 'This field must be a valid email address.',
    'ends_with' => 'This field must end with specific values.',
    'enum' => 'This field must be one of the allowed values.',
    'exists' => 'This field is invalid.',
    'file' => 'This field must be a file.',
    'filled' => 'This field must have a value.',
    'gt' => [
        'array' => 'This field must have more than a certain number of items.',
        'file' => 'This field must be larger than a certain size.',
        'numeric' => 'This field must be greater than a specific value.',
        'string' => 'This field must have more than a certain number of characters.',
    ],
    'gte' => [
        'array' => 'This field must have a specific number of items or more.',
        'file' => 'This field must be at least a certain size.',
        'numeric' => 'This field must be at least a certain value.',
        'string' => 'This field must have at least a certain number of characters.',
    ],
    'image' => 'This field must be an image.',
    'in' => 'This field is invalid.',
    'in_array' => 'This field must be present in another field.',
    'integer' => 'This field must be an integer.',
    'ip' => 'This field must be a valid IP address.',
    'ipv4' => 'This field must be a valid IPv4 address.',
    'ipv6' => 'This field must be a valid IPv6 address.',
    'json' => 'This field must be a valid JSON string.',
    'lowercase' => 'This field must be lowercase.',
    'lt' => [
        'array' => 'This field must have fewer than a certain number of items.',
        'file' => 'This field must be smaller than a certain size.',
        'numeric' => 'This field must be less than a certain value.',
        'string' => 'This field must have fewer than a certain number of characters.',
    ],
    'lte' => [
        'array' => 'This field must have no more than a certain number of items.',
        'file' => 'This field must be at most a certain size.',
        'numeric' => 'This field must be no more than a certain value.',
        'string' => 'This field must have no more than a certain number of characters.',
    ],
    'mac_address' => 'This field must be a valid MAC address.',
    'max' => [
        'array' => 'This field must have no more than a certain number of items.',
        'file' => 'This field must be no larger than a certain size.',
        'numeric' => 'This field must be no more than a certain value.',
        'string' => 'This field must be no longer than a certain number of characters.',
    ],
    'max_digits' => 'This field must have no more than a certain number of digits.',
    'mimes' => 'This field must be a specific type of file.',
    'mimetypes' => 'This field must be a specific type of file.',
    'min' => [
        'array' => 'This field must have at least a certain number of items.',
        'file' => 'This field must be at least a certain size.',
        'numeric' => 'This field must be at least a certain value.',
        'string' => 'This field must be at least a certain number of characters.',
    ],
    'min_digits' => 'This field must have at least a certain number of digits.',
    'missing' => 'This field must be missing.',
    'missing_if' => 'This field must be missing under certain conditions.',
    'missing_unless' => 'This field must be missing unless certain conditions are met.',
    'missing_with' => 'This field must be missing when certain fields are present.',
    'missing_with_all' => 'This field must be missing when certain fields are present.',
    'multiple_of' => 'This field must be a multiple of a certain value.',
    'not_in' => 'This field is invalid.',
    'not_regex' => 'This field format is invalid.',
    'numeric' => 'This field must be a number.',
    'password' => [
        'letters' => 'This field must contain at least one letter.',
        'mixed' => 'This field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'This field must contain at least one number.',
        'symbols' => 'This field must contain at least one symbol.',
        'uncompromised' => 'This field has appeared in a data leak. Please choose a different value.',
    ],
    'present' => 'This field must be present.',
    'prohibited' => 'This field must not be present.',
    'prohibited_if' => 'This field must not be present under certain conditions.',
    'prohibited_unless' => 'This field must not be present unless certain conditions are met.',
    'prohibits' => 'This field must not be present under certain conditions.',
    'regex' => 'This field format is invalid.',
    'required' => 'This field is required.',
    'required_array_keys' => 'This field must contain entries for certain values.',
    'required_if' => 'This field is required under certain conditions.',
    'required_if_accepted' => 'This field is required when certain conditions are met.',
    'required_unless' => 'This field is required unless certain conditions are met.',
    'required_with' => 'This field is required when certain fields are present.',
    'required_with_all' => 'This field is required when certain fields are present.',
    'required_without' => 'This field is required when certain fields are not present.',
    'required_without_all' => 'This field is required when none of certain fields are present.',
    'same' => 'This field must match another field.',
    'size' => [
        'array' => 'This field must have a certain number of items.',
        'file' => 'This field must be a certain size.',
        'numeric' => 'This field must be a certain value.',
        'string' => 'This field must have a certain number of characters.',
    ],
    'starts_with' => 'This field must start with specific values.',
    'string' => 'This field must be a string.',
    'timezone' => 'This field must be a valid timezone.',
    'unique' => 'This field must be unique.',
    'uploaded' => 'This field failed to upload.',
    'uppercase' => 'This field must be uppercase.',
    'url' => 'This field must be a valid URL.',
    'ulid' => 'This field must be a valid ULID.',
    'uuid' => 'This field must be a valid UUID.',

    'list' => 'This field must be a list.',
    'map' => 'This field must be a map.',
    'prohibited_with' => 'This field must not be present under certain conditions.',
    'prohibited_with_all' => 'This field must not be present under certain conditions.',
    'prohibited_without' => 'This field must not be present under certain conditions.',
    'prohibited_without_all' => 'This field must not be present under certain conditions.',
    'throttled' => 'Please wait before retrying.',
    'invalid' => 'This field is invalid.',
];
