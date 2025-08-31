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

namespace Premierstacks\LaravelStack\Fake;

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\Encoding\Svg;
use Premierstacks\PhpStack\Fake\Svg as FakeSvg;

class ImageFaker
{
    use InjectTrait;

    /**
     * @param 'bmp'|'gif'|'jpeg'|'png'|'wbmp'|'webp' $extension
     */
    public function blank(int $width = 10, int $height = 10, string $extension = 'webp'): File
    {
        return UploadedFile::fake()->image(Str::random() . ".{$extension}", $width, $height);
    }

    /**
     * @param 'bmp'|'gif'|'jpeg'|'png'|'wbmp'|'webp' $extension
     */
    public function placeholder(int $width = 800, int $height = 600, string $extension = 'webp'): File
    {
        return UploadedFile::fake()->createWithContent(Str::random() . ".{$extension}", Svg::encode(FakeSvg::placeholder($width, $height), $extension));
    }
}
