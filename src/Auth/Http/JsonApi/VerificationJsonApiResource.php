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

namespace Premierstacks\LaravelStack\Auth\Http\JsonApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\LaravelStack\Verification\VerificationInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiResource;
use Premierstacks\PhpStack\Mixed\Assert;

class VerificationJsonApiResource extends JsonApiResource
{
    use InjectTrait;

    public function __construct(public VerificationInterface $verification)
    {
        parent::__construct();
    }

    public function getActionTrans(): string|null
    {
        $trans = $this->getTrans();

        $action = $this->verification->getAction();

        if ($trans->has($action)) {
            return $trans->string($action);
        }

        if ($trans->has("actions.{$action}.title")) {
            return $trans->string("actions.{$action}.title");
        }

        if ($trans->has("psls::actions.{$action}.title")) {
            return $trans->string("psls::actions.{$action}.title");
        }

        return null;
    }

    /**
     * @return iterable<array-key, mixed>
     */
    #[\Override]
    public function getAttributes(): iterable
    {
        yield from parent::getAttributes() ?? [];

        yield from $this->getVerificationAttributes();
    }

    #[\Override]
    public function getId(): string
    {
        $id = parent::getId();

        if ($id !== null) {
            return $id;
        }

        if ($this->verification instanceof Model) {
            return (string) Assert::arrayKey($this->verification->getKey());
        }

        return $this->verification->getVerificationId();
    }

    #[\Override]
    public function getSlug(): string
    {
        $slug = parent::getSlug();

        if ($slug !== null) {
            return $slug;
        }

        if ($this->verification instanceof Model) {
            return (string) Assert::arrayKey($this->verification->getRouteKey());
        }

        return $this->getId();
    }

    public function getTrans(): Trans
    {
        return Trans::inject();
    }

    #[\Override]
    public function getType(): string
    {
        $type = parent::getType();

        if ($type !== null) {
            return $type;
        }

        if ($this->verification instanceof Model) {
            return $this->verification->getTable();
        }

        return Str::slug($this->verification::class, '_', null);
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getVerificationAttributes(): iterable
    {
        yield 'action' => $this->verification->getAction();

        yield 'action_trans' => $this->getActionTrans();

        yield 'duration' => $this->verification->getDuration();

        yield 'expires_at' => $this->verification->getExpiresAt()->toJSON();

        yield 'uses' => $this->verification->getUses();

        yield 'verification_id' => $this->verification->getVerificationId();

        yield 'verified_at' => $this->verification->getVerifiedAt()?->toJSON();

        yield 'is_active' => $this->verification->isActive();

        yield 'is_ready' => $this->verification->isReady();

        yield 'is_completed' => $this->verification->isCompleted();

        yield 'pair' => $this->verification->getPair();
    }
}
