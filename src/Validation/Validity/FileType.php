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

class FileType
{
    public function __construct(public FileValidity $validity) {}

    public function image(): FileValidity
    {
        return $this->validity->mimetypes([
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/svg+xml',
            'image/svg',
            'image/webp',
            'image/bmp',
            'image/x-bmp',
            'image/x-ms-bmp',
            'image/heif',
            'image/heic',
        ]);
    }

    /**
     * @param array<array-key, string> $mimes
     */
    public function mimes(array $mimes): FileValidity
    {
        return $this->validity->mimes($mimes);
    }

    /**
     * @param array<array-key, string> $mimes
     */
    public function mimetypes(array $mimes): FileValidity
    {
        return $this->validity->mimetypes($mimes);
    }

    public function unlimited(): FileValidity
    {
        return $this->validity;
    }

    public function video(): FileValidity
    {
        return $this->validity->mimetypes(['video/mp4', 'video/mpeg', 'video/ogg', 'video/quicktime', 'video/webm']);
    }
}
