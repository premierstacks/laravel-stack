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

use Premierstacks\LaravelStack\Notifications\VerificationNotification;

return [
    VerificationNotification::class => [
        'token' => [
            'subject' => 'Action Authorization Request',
            'line_1' => 'This email has been sent as part of the verification process for continuing with a required action on your account.',
            'line_2' => 'To view details and confirm this action, please click the button below.',
            'line_3' => 'You are about to authorize the action: :action',
            'line_expiration' => 'Please note that this link will expire soon.',
            'line_not_you' => 'If you did not initiate this action, please ignore this email or inform us.',
            'button' => 'View Request',
        ],
        'code' => [
            'subject' => 'Request for Manual Action Authorization',
            'line_1' => 'This email has been sent as part of the security process for manual authorization of an action on your account.',
            'line_2' => 'Below you will find a code that must be entered into the application to complete the authorization process.',
            'line_3' => 'You are about to authorize the action: :action',
            'line_expiration' => 'Please note that this code will expire soon.',
            'line_not_you' => 'If you did not initiate this action, please ignore this email or inform us.',
            'button' => 'Show Authorization Code',
        ],
    ],
];
