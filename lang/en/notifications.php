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
            'subject' => 'Confirm the action in your account',
            'line_1_title' => 'Content:',
            'line_1' => 'This email was sent as part of the security process for your account. To proceed with the requested action, it is necessary to confirm its validity.',
            'line_2_title' => 'What is happening:',
            'line_2' => 'You are confirming the action - :action',
            'line_4_title' => 'How to proceed:',
            'line_4' => 'Click the button below and follow the instructions on the page. The button will redirect you to a page where you can safely confirm the action.',
            'line_expiration_title' => 'Notice:',
            'line_expiration' => 'The link is time-limited. If you do not confirm the action in time, you will need to start the process again.',
            'line_not_you_title' => 'Not you?',
            'line_not_you' => 'If you did not initiate this action, simply ignore this email. If in doubt, please contact us immediately.',
            'button' => 'Confirm Action',
        ],
        'code' => [
            'subject' => 'Request for Manual Action Authorization',
            'line_1' => 'This email has been sent as part of the security process for manual authorization of an action on your account.',
            'line_2' => 'Below you will find a code that must be entered into the application to complete the authorization process.',
            'line_3' => 'You are about to authorize the action: :action',
            'line_4' => 'Pair code: :pair',
            'line_expiration' => 'Please note that this code will expire soon.',
            'line_not_you' => 'If you did not initiate this action, please ignore this email or inform us.',
            'button' => 'Show Authorization Code',
        ],
    ],
];
