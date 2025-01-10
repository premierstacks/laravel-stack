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

namespace Premierstacks\LaravelStack\Validation\Validity;

class CarbonLimits
{
    public static bool $micro = true;

    public function __construct(public CarbonValidity $validity) {}

    public function date(): CarbonValidity
    {
        return $this->validity->setBase([$this->validity->encodeRule('date_format', ['Y-m-d'])]);
    }

    public function format(string $format): CarbonValidity
    {
        return $this->validity->setBase([$this->validity->encodeRule('date_format', [$format])]);
    }

    public function hours(): CarbonValidity
    {
        return $this->validity->setBase([$this->validity->encodeRule('date_format', ['H'])]);
    }

    public function iso(bool|null $micro = null): CarbonValidity
    {
        $micro ??= static::$micro;
        $scale = $micro ? 'u' : 'v';

        return $this->validity->setBase([$this->validity->encodeRule('date_format', ["Y-m-d\\TH:i:s.{$scale}p"])]);
    }

    public function minutes(): CarbonValidity
    {
        return $this->validity->setBase([$this->validity->encodeRule('date_format', ['H:i'])]);
    }

    public function seconds(): CarbonValidity
    {
        return $this->validity->setBase([$this->validity->encodeRule('date_format', ['H:i:s'])]);
    }

    public function unsafe(): CarbonValidity
    {
        return $this->validity;
    }

    public function utc(bool|null $micro = null): CarbonValidity
    {
        $micro ??= static::$micro;
        $scale = $micro ? 'u' : 'v';

        return $this->validity->setBase([$this->validity->encodeRule('date_format', ["Y-m-d\\TH:i:s.{$scale}\\Z"])]);
    }
}
