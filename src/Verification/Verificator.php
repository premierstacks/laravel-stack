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
    public function complete(VerificationInterface $verification): bool
    {
        return $verification->complete();
    }

    #[\Override]
    public function create(
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
    public function decrementUses(VerificationInterface $verification): bool
    {
        return $verification->decrementUses();
    }

    public function newVerification(): Verification
    {
        return Verification::inject();
    }

    #[\Override]
    public function retrieveActive(string $sessionId, iterable $context): VerificationInterface|null
    {
        return $this->newVerification()->retrieveActive($sessionId, $context);
    }

    #[\Override]
    public function retrieveByVerificationId(string $verificationId): VerificationInterface|null
    {
        return $this->newVerification()->retrieveByVerificationId($verificationId);
    }
}
