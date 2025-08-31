<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
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

interface VerificationInterface
{
    public function complete(): bool;

    public function decrementUses(): bool;

    public function getAction(): string;

    public function getContext(): string;

    public function getDuration(): int;

    public function getExpiresAt(): Carbon;

    public function getHash(): string;

    public function getPair(): string;

    public function getSessionId(): string;

    public function getToken(): string|null;

    public function getUses(): int;

    public function getVerificationId(): string;

    public function getVerifiedAt(): Carbon|null;

    public function isActive(): bool;

    public function isCompleted(): bool;

    public function isReady(): bool;

    public function validateToken(string $token): bool;
}
