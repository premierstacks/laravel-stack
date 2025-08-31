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

namespace Premierstacks\LaravelStack\JsonApi;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\JsonApi\JsonApiMeta;

class PaginatorJsonApiMeta extends JsonApiMeta
{
    use InjectTrait;

    /**
     * @param Paginator<array-key, mixed> $paginator
     */
    public function __construct(public Paginator $paginator)
    {
        parent::__construct();
    }

    #[\Override]
    public function getIterator(): \Traversable
    {
        yield from parent::getIterator();

        yield from $this->getPaginatorMeta();
    }

    /**
     * @return iterable<array-key, mixed>
     */
    public function getPaginatorMeta(): iterable
    {
        if ($this->paginator instanceof CursorPaginator) {
            return [
                'paginator' => [
                    'next' => $this->paginator->nextCursor()?->encode(),
                    'prev' => $this->paginator->previousCursor()?->encode(),
                ],
            ];
        }

        if ($this->paginator instanceof LengthAwarePaginator) {
            return [
                'paginator' => [
                    'count' => $this->paginator->total(),
                    'next' => $this->paginator->hasMorePages() ? $this->paginator->currentPage() + 1 : null,
                    'prev' => $this->paginator->currentPage() !== 1
                            ? ($this->paginator->currentPage() <= $this->paginator->lastPage()
                                ? $this->paginator->currentPage() - 1
                                : $this->paginator->lastPage())
                            : null,
                ],
            ];
        }

        yield 'paginator' => [
            'next' => $this->paginator->hasMorePages() ? $this->paginator->currentPage() + 1 : null,
            'prev' => $this->paginator->currentPage() !== 1 ? $this->paginator->currentPage() - 1 : null,
        ];
    }
}
