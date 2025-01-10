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

namespace Premierstacks\LaravelStack\Verification;

use Illuminate\Support\Carbon;

interface VerificatorInterface
{
    public function complete(VerificationInterface $verification): bool;

    /**
     * @param iterable<array-key, mixed> $context
     */
    public function create(string $sessionId, string $verificationId, string $token, string $pair, iterable $context, string $action, Carbon $expiresAt, int $duration, int $uses, Carbon|null $verifiedAt): VerificationInterface;

    public function decrementUses(VerificationInterface $verification): bool;

    /**
     * @param iterable<array-key, mixed> $context
     */
    public function retrieveActive(string $sessionId, iterable $context): VerificationInterface|null;

    public function retrieveByVerificationId(string $verificationId): VerificationInterface|null;
}
