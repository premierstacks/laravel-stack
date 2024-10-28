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

namespace Premierstacks\LaravelStack\Throttle;

use Illuminate\Cache\RateLimiting\Limit as IlluminateLimit;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Http\RequestSignature;
use Symfony\Component\HttpFoundation\Response;

class Limit extends IlluminateLimit
{
    use InjectTrait;

    /**
     * @param \Closure(): Response|\Closure(): never|null $responseCallback
     */
    public function __construct(string $key = '', int $maxAttempts = 5, int $decaySeconds = 600, \Closure|null $responseCallback = null)
    {
        parent::__construct(RequestSignature::inject()->getHash() . ':' . $key, $maxAttempts, $decaySeconds);

        if ($responseCallback !== null) {
            $this->responseCallback = $responseCallback;
        }
    }

    /**
     * @param \Closure(): Response|\Closure(): never|null $responseCallback
     */
    public static function dependency(string $key = '', int $maxAttempts = 5, int $decaySeconds = 600, \Closure|null $responseCallback = null): static
    {
        return static::inject(['key' => $key, 'maxAttempts' => $maxAttempts, 'decaySeconds' => $decaySeconds, 'responseCallback' => $responseCallback]);
    }
}
