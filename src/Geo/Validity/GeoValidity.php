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

namespace Premierstacks\LaravelStack\Geo\Validity;

use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Geo\Enums\Iso3166Char2;
use Premierstacks\LaravelStack\Geo\Enums\Iso3166Char3;
use Premierstacks\LaravelStack\Geo\Objects\Point;
use Premierstacks\LaravelStack\Geo\Rules\PointRule;
use Premierstacks\LaravelStack\Validation\Validity\FloatValidity;
use Premierstacks\LaravelStack\Validation\Validity\ListValidity;
use Premierstacks\LaravelStack\Validation\Validity\MapValidity;
use Premierstacks\LaravelStack\Validation\Validity\StringValidity;
use Premierstacks\LaravelStack\Validation\Validity\Validity;

class GeoValidity
{
    use InjectTrait;

    public function bbox(): ListValidity
    {
        return Validity::list()->size(2);
    }

    public function iso3166char2(): StringValidity
    {
        return Validity::string()->enum(Iso3166Char2::class);
    }

    public function iso3166char3(): StringValidity
    {
        return Validity::string()->enum(Iso3166Char3::class);
    }

    public function lat(): FloatValidity
    {
        return Validity::float()->between(-90, 90);
    }

    public function lng(): FloatValidity
    {
        return Validity::float()->between(-180, 180)->notIn([-180]);
    }

    /**
     * @param (\Closure(Point, string, mixed, Validator, \Closure(string): PotentiallyTranslatedString): bool|null)|null $validate
     */
    public function point(\Closure|null $validate = null): MapValidity
    {
        return Validity::map()->exact(['lat', 'lng'])->add(new PointRule($validate));
    }
}
