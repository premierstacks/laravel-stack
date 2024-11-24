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

namespace Premierstacks\LaravelStack\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolver;
use Premierstacks\PhpStack\Debug\Errorf;

class Migrator
{
    use InjectTrait;

    /**
     * @param \Closure(Blueprint): void $closure
     */
    public function createAuthenticatableTable(string $table, \Closure|null $closure = null): void
    {
        $this->getSchemaBuilder()->create($table, static function (Blueprint $table) use ($closure): void {
            $table->id();

            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->char('locale', 2);

            $closure?->__invoke($table);

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * @param \Closure(Blueprint): void $closure
     */
    public function createPasswordResetTokensTable(string $table, \Closure|null $closure = null): void
    {
        $this->getSchemaBuilder()->create($table, static function (Blueprint $table) use ($closure): void {
            $table->string('email')->primary();
            $table->string('token');

            $closure?->__invoke($table);

            $table->timestamp('created_at')->nullable();
        });
    }

    public function createUnlimitedTokensColumn(string $table, string $column, string $on, string $referencing, string $type = 'id'): void
    {
        $this->getSchemaBuilder()->table($table, static function (Blueprint $blueprint) use ($column, $on, $referencing, $type): void {
            match ($type) {
                'id' => $blueprint
                    ->foreignId($column)
                    ->nullable()
                    ->constrained($on, $referencing)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete(),
                'uuid' => $blueprint
                    ->foreignUuid($column)
                    ->nullable()
                    ->constrained($on, $referencing)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete(),
                'ulid' => $blueprint
                    ->foreignUlid($column)
                    ->nullable()
                    ->constrained($on, $referencing)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete(),
                default => throw new \LogicException(Errorf::unexpectedValue($type, 'id|uuid|ulid')),
            };
        });
    }

    /**
     * @param \Closure(Blueprint): void $closure
     */
    public function createUnlimitedTokensTable(string $table, \Closure|null $closure = null): void
    {
        $this->getSchemaBuilder()->create($table, static function (Blueprint $table) use ($closure): void {
            $table->id();

            $table->string('token');

            $table->string('authenticatable_id');
            $table->string('password')->nullable();

            $table->string('guard_name');
            $table->string('user_provider_name');

            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('origin')->nullable();

            $closure?->__invoke($table);

            $table->dateTime('revoked_at')->nullable();

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * @param \Closure(Blueprint): void $closure
     */
    public function createVerificationsTable(string $table, \Closure|null $closure = null): void
    {
        $this->getSchemaBuilder()->create($table, static function (Blueprint $table): void {
            $table->id();

            $table->string('session_id');
            $table->string('context');
            $table->unsignedInteger('duration');
            $table->dateTime('expires_at');
            $table->dateTime('verified_at')->nullable();
            $table->string('verification_id');
            $table->string('hash');
            $table->integer('uses');
            $table->string('action');
            $table->string('pair');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    public function getSchemaBuilder(): SchemaBuilder
    {
        return Resolver::schemaBuilder();
    }
}
