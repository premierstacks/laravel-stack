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

namespace Premierstacks\LaravelStack\Verification;

use Illuminate\Support\Carbon;

interface VerificatorInterface
{
    /**
     * @param iterable<array-key, mixed> $context
     */
    public function check(string $sessionId, iterable $context): bool;

    public function complete(string $verificationId): bool;

    /**
     * @param iterable<array-key, mixed> $context
     */
    public function createVerification(string $sessionId, string $verificationId, string $token, string $pair, iterable $context, string $action, Carbon $expiresAt, int $duration, int $uses, Carbon|null $verifiedAt): VerificationInterface;

    /**
     * @param iterable<array-key, mixed> $context
     */
    public function decrement(string $sessionId, iterable $context): bool;

    public function retrieve(string $verificationId): VerificationInterface|null;

    public function validate(string $verificationId, string $token): bool;
}
