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

return [
    0 => ['title' => 'Unknown response'],

    100 => ['title' => 'Continue'],
    101 => ['title' => 'Switching protocols'],
    102 => ['title' => 'Processing'],
    103 => ['title' => 'Early hints'],

    200 => ['title' => 'OK'],
    201 => ['title' => 'Created'],
    202 => ['title' => 'Accepted'],
    203 => ['title' => 'Non-authoritative information'],
    204 => ['title' => 'No content'],
    205 => ['title' => 'Reset content'],
    206 => ['title' => 'Partial content'],
    207 => ['title' => 'Multi-status'],
    208 => ['title' => 'Already reported'],
    226 => ['title' => 'IM used'],

    300 => ['title' => 'Multiple choices'],
    301 => ['title' => 'Moved permanently'],
    302 => ['title' => 'Found'],
    303 => ['title' => 'See other'],
    304 => ['title' => 'Not modified'],
    305 => ['title' => 'Use proxy'],
    307 => ['title' => 'Temporary redirect'],
    308 => ['title' => 'Permanent redirect'],

    400 => ['title' => 'Bad request'],
    401 => ['title' => 'Sorry, you are not authorized to access this page'],
    402 => ['title' => 'Payment required'],
    403 => ['title' => 'Sorry, you are forbidden from accessing this page'],
    404 => ['title' => 'Sorry, the page you are looking for could not be found'],
    405 => ['title' => 'Method not allowed'],
    406 => ['title' => 'Not acceptable'],
    407 => ['title' => 'Proxy authentication required'],
    408 => ['title' => 'Request timeout'],
    409 => ['title' => 'Conflict'],
    410 => ['title' => 'Gone'],
    411 => ['title' => 'Length required'],
    412 => ['title' => 'Precondition failed'],
    413 => ['title' => 'Payload too large'],
    414 => ['title' => 'URI too long'],
    415 => ['title' => 'Unsupported media type'],
    416 => ['title' => 'Range not satisfiable'],
    417 => ['title' => 'Expectation failed'],
    418 => ['title' => 'I\'m a teapot'],
    419 => ['title' => 'Sorry, your session has expired, please refresh and try again'],
    421 => ['title' => 'Misdirected request'],
    422 => ['title' => 'The given data was invalid'],
    423 => ['title' => 'Locked'],
    424 => ['title' => 'Failed dependency'],
    425 => ['title' => 'Too early'],
    426 => ['title' => 'Upgrade required'],
    427 => ['title' => 'Log out first'],
    428 => ['title' => 'Precondition required'],
    429 => ['title' => 'Sorry, you are making too many requests to our servers'],
    431 => ['title' => 'Request header fields too large'],
    451 => ['title' => 'Unavailable for legal reasons'],

    500 => ['title' => 'Whoops, something went wrong on our servers'],
    501 => ['title' => 'Not implemented'],
    502 => ['title' => 'Bad gateway'],
    503 => ['title' => 'Sorry, we are doing some maintenance, please check back soon'],
    504 => ['title' => 'Gateway timeout'],
    505 => ['title' => 'HTTP version not supported'],
    506 => ['title' => 'Variant also negotiate'],
    507 => ['title' => 'Insufficient storage'],
    508 => ['title' => 'Loop detected'],
    510 => ['title' => 'Not extended'],
    511 => ['title' => 'Network authentication required'],
];
