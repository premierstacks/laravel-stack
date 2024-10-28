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

namespace Premierstacks\LaravelStack\Eloquent;

use Illuminate\Database\Eloquent\Model as IlluminateModel;

class MixedModel extends IlluminateModel
{
    use MixedModelTrait;

    public function mustDelete(): true
    {
        $deleted = $this->delete();

        if ($deleted !== true) {
            throw new \RuntimeException('Failed to delete the model.');
        }

        return true;
    }

    /**
     * @param array<array-key, mixed> $options
     */
    public function mustSave(array $options = []): true
    {
        $saved = $this->save($options);

        if ($saved !== true) {
            throw new \RuntimeException('Failed to save the model.');
        }

        return true;
    }

    /**
     * @param array<array-key, mixed> $attributes
     * @param array<array-key, mixed> $options
     */
    public function mustUpdate(array $attributes = [], array $options = []): true
    {
        $updated = $this->update($attributes, $options);

        if ($updated !== true) {
            throw new \RuntimeException('Failed to update the model.');
        }

        return true;
    }
}
