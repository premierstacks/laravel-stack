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

namespace Premierstacks\LaravelStack\Validation\Validity;

use Illuminate\Validation\Rules\Dimensions;

class FileValidity extends MixedValidity
{
    use SizeValidityTrait;

    /**
     * @return $this
     */
    public function dimensions(
        int|null $width = null,
        int|null $height = null,
        int|null $minWidth = null,
        int|null $maxWidth = null,
        int|null $minHeight = null,
        int|null $maxHeight = null,
        float|null $ratio = null,
    ): static {
        $dimensions = new Dimensions([]);

        if ($width !== null) {
            $dimensions->width($width);
        }

        if ($height !== null) {
            $dimensions->height($height);
        }

        if ($minWidth !== null) {
            $dimensions->minWidth($minWidth);
        }

        if ($maxWidth !== null) {
            $dimensions->maxWidth($maxWidth);
        }

        if ($minHeight !== null) {
            $dimensions->minHeight($minHeight);
        }

        if ($maxHeight !== null) {
            $dimensions->maxHeight($maxHeight);
        }

        if ($ratio !== null) {
            $dimensions->ratio($ratio);
        }

        return $this->add((string) $dimensions);
    }

    #[\Override]
    public function getBase(): array
    {
        return $this->base ?? ['file'];
    }

    /**
     * @param array<array-key, string> $mimes
     *
     * @return $this
     */
    public function mimes(array $mimes): static
    {
        return $this->add('mimes', $mimes);
    }

    /**
     * @param array<array-key, string> $mimetypes
     *
     * @return $this
     */
    public function mimetypes(array $mimetypes): static
    {
        return $this->add('mimetypes', $mimetypes);
    }
}
