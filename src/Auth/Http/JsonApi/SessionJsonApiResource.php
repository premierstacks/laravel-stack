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

namespace Premierstacks\LaravelStack\Auth\Http\JsonApi;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Str;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\JsonApi\JsonApiResource;

class SessionJsonApiResource extends JsonApiResource
{
    use InjectTrait;

    public function __construct(public Session $session)
    {
        parent::__construct();
    }

    #[\Override]
    public function getId(): string
    {
        $id = parent::getId();

        if ($id !== null) {
            return $id;
        }

        return $this->session->getId();
    }

    #[\Override]
    public function getSlug(): string
    {
        $slug = parent::getId();

        if ($slug !== null) {
            return $slug;
        }

        return $this->getId();
    }

    #[\Override]
    public function getType(): string
    {
        $type = parent::getType();

        if ($type !== null) {
            return $type;
        }

        return Str::slug($this->session::class, '_', null);
    }
}
