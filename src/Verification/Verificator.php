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
use Premierstacks\LaravelStack\Container\InjectTrait;

class Verificator implements VerificatorInterface
{
    use InjectTrait;

    #[\Override]
    public function check(string $sessionId, iterable $context): bool
    {
        $verification = $this->newVerification();

        $query = $verification->newQuery();

        $verification->scopeActive($query);
        $verification->scopeContext($query, $sessionId, $context);

        return $query->getQuery()->exists();
    }

    #[\Override]
    public function complete(string $verificationId): bool
    {
        $verification = $this->retrieve($verificationId);

        if (!$verification instanceof Verification) {
            return false;
        }

        if ($verification->isCompleted()) {
            return true;
        }

        return $verification->asVerified()->mustSave();
    }

    #[\Override]
    public function createVerification(
        string $sessionId,
        string $verificationId,
        string $token,
        string $pair,
        iterable $context,
        string $action,
        Carbon $expiresAt,
        int $duration,
        int $uses,
        Carbon|null $verifiedAt,
    ): VerificationInterface {
        $verification = $this->newVerification();

        $verification->setSessionId($sessionId);
        $verification->setVerificationId($verificationId);
        $verification->setToken($token);
        $verification->setPair($pair);
        $verification->setContext($context);
        $verification->setAction($action);
        $verification->setExpiresAt($expiresAt);
        $verification->setDuration($duration);
        $verification->setUses($uses);
        $verification->setVerifiedAt($verifiedAt);

        $verification->mustSave();

        return $verification;
    }

    #[\Override]
    public function decrement(string $sessionId, iterable $context): bool
    {
        $verification = $this->newVerification();

        $query = $verification->newQuery();

        $verification->scopeActive($query);
        $verification->scopeContext($query, $sessionId, $context);

        $verification = $query->first();

        if (!$verification instanceof Verification) {
            return false;
        }

        return $verification->decrementUses();
    }

    public function newVerification(): Verification
    {
        return Verification::inject();
    }

    #[\Override]
    public function retrieve(string $verificationId): VerificationInterface|null
    {
        return $this->newVerification()->retrieveByVerificationId($verificationId);
    }

    #[\Override]
    public function validate(string $verificationId, string $token): bool
    {
        $verification = $this->retrieve($verificationId);

        if (!$verification instanceof Verification) {
            return false;
        }

        if (!$verification->isReady()) {
            return false;
        }

        return $verification->validateToken($token);
    }
}
