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
    'accepted' => 'The :attribute field must be accepted.',
    'accepted_if' => 'The :attribute field must meet certain conditions to be accepted.',
    'active_url' => 'The :attribute field must be a valid URL.',
    'after' => 'The :attribute field must be a date after a specific date.',
    'after_or_equal' => 'The :attribute field must be a date after or equal to a specific date.',
    'alpha' => 'The :attribute field must only contain letters.',
    'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'The :attribute field must only contain letters and numbers.',
    'array' => 'The :attribute field must be an array.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'The :attribute field must be a date before a specific date.',
    'before_or_equal' => 'The :attribute field must be a date before or equal to a specific date.',
    'between' => [
        'array' => 'The :attribute field must have a specific range of items.',
        'file' => 'The :attribute field must be within a specific size range.',
        'numeric' => 'The :attribute field must be within a specific range.',
        'string' => 'The :attribute field must have a specific range of characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => 'The :attribute field confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute field must be a valid date.',
    'date_equals' => 'The :attribute field must match a specific date.',
    'date_format' => 'The :attribute field must match a specific format.',
    'decimal' => 'The :attribute field must have a certain number of decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined under certain conditions.',
    'different' => 'The :attribute field must be different from another field.',
    'digits' => 'The :attribute field must have a specific number of digits.',
    'digits_between' => 'The :attribute field must have digits within a certain range.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute field must not end with specific values.',
    'doesnt_start_with' => 'The :attribute field must not start with specific values.',
    'email' => 'The :attribute field must be a valid email address.',
    'ends_with' => 'The :attribute field must end with specific values.',
    'enum' => 'The :attribute field must be one of the allowed values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute field must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute field must have more than a certain number of items.',
        'file' => 'The :attribute field must be larger than a certain size.',
        'numeric' => 'The :attribute field must be greater than a specific value.',
        'string' => 'The :attribute field must have more than a certain number of characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have a specific number of items or more.',
        'file' => 'The :attribute field must be at least a certain size.',
        'numeric' => 'The :attribute field must be at least a certain value.',
        'string' => 'The :attribute field must have at least a certain number of characters.',
    ],
    'image' => 'The :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must be present in another field.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have fewer than a certain number of items.',
        'file' => 'The :attribute field must be smaller than a certain size.',
        'numeric' => 'The :attribute field must be less than a certain value.',
        'string' => 'The :attribute field must have fewer than a certain number of characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must have no more than a certain number of items.',
        'file' => 'The :attribute field must be at most a certain size.',
        'numeric' => 'The :attribute field must be no more than a certain value.',
        'string' => 'The :attribute field must have no more than a certain number of characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute field must have no more than a certain number of items.',
        'file' => 'The :attribute field must be no larger than a certain size.',
        'numeric' => 'The :attribute field must be no more than a certain value.',
        'string' => 'The :attribute field must be no longer than a certain number of characters.',
    ],
    'max_digits' => 'The :attribute field must have no more than a certain number of digits.',
    'mimes' => 'The :attribute field must be a specific type of file.',
    'mimetypes' => 'The :attribute field must be a specific type of file.',
    'min' => [
        'array' => 'The :attribute field must have at least a certain number of items.',
        'file' => 'The :attribute field must be at least a certain size.',
        'numeric' => 'The :attribute field must be at least a certain value.',
        'string' => 'The :attribute field must be at least a certain number of characters.',
    ],
    'min_digits' => 'The :attribute field must have at least a certain number of digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing under certain conditions.',
    'missing_unless' => 'The :attribute field must be missing unless certain conditions are met.',
    'missing_with' => 'The :attribute field must be missing when certain fields are present.',
    'missing_with_all' => 'The :attribute field must be missing when certain fields are present.',
    'multiple_of' => 'The :attribute field must be a multiple of a certain value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => 'The :attribute field must be a number.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field must not be present.',
    'prohibited_if' => 'The :attribute field must not be present under certain conditions.',
    'prohibited_unless' => 'The :attribute field must not be present unless certain conditions are met.',
    'prohibits' => 'The :attribute field must not be present under certain conditions.',
    'regex' => 'The :attribute field format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for certain values.',
    'required_if' => 'The :attribute field is required under certain conditions.',
    'required_if_accepted' => 'The :attribute field is required when certain conditions are met.',
    'required_unless' => 'The :attribute field is required unless certain conditions are met.',
    'required_with' => 'The :attribute field is required when certain fields are present.',
    'required_with_all' => 'The :attribute field is required when certain fields are present.',
    'required_without' => 'The :attribute field is required when certain fields are not present.',
    'required_without_all' => 'The :attribute field is required when none of certain fields are present.',
    'same' => 'The :attribute field must match another field.',
    'size' => [
        'array' => 'The :attribute field must have a certain number of items.',
        'file' => 'The :attribute field must be a certain size.',
        'numeric' => 'The :attribute field must be a certain value.',
        'string' => 'The :attribute field must have a certain number of characters.',
    ],
    'starts_with' => 'The :attribute field must start with specific values.',
    'string' => 'The :attribute field must be a string.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'The :attribute field must be unique.',
    'uploaded' => 'The :attribute field failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

    'list' => 'The :attribute field must be a list.',
    'map' => 'The :attribute field must be a map.',
    'prohibited_with' => 'The :attribute field must not be present under certain conditions.',
    'prohibited_with_all' => 'The :attribute field must not be present under certain conditions.',
    'prohibited_without' => 'The :attribute field must not be present under certain conditions.',
    'prohibited_without_all' => 'The :attribute field must not be present under certain conditions.',
    'throttled' => 'Please wait before retrying.',
    'invalid' => 'The selected :attribute is invalid.',
];
