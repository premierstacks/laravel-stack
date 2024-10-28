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

interface VerificationInterface
{
    public function getAction(): string;

    public function getContext(): string;

    public function getDuration(): int;

    public function getExpiresAt(): Carbon;

    public function getPair(): string;

    public function getSessionId(): string;

    public function getToken(): string;

    public function getUses(): int;

    public function getVerificationId(): string;

    public function getVerifiedAt(): Carbon|null;

    public function isActive(): bool;

    public function isCompleted(): bool;

    public function isReady(): bool;
}