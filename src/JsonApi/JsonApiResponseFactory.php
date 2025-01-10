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

namespace Premierstacks\LaravelStack\JsonApi;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\JsonApi\JsonApiDocumentInterface;
use Premierstacks\PhpStack\JsonApi\JsonApiSerializer;
use Premierstacks\PhpStack\Mixed\Filter;

class JsonApiResponseFactory
{
    use InjectTrait;

    public function __construct(public ResponseFactory $responseFactory, public JsonApiSerializer $jsonApiSerializer) {}

    public function detectStatus(object|null $content): int
    {
        if ($content === null) {
            return 204;
        }

        $statuses = \data_get($content, 'errors.*.status');

        if (!\is_iterable($statuses) || $statuses === []) {
            return 200;
        }

        $current = null;

        foreach ($statuses as $status) {
            $status = Filter::nullableInt($status);

            if ($current === null) {
                $current = $status;
            } elseif ($status === null || $status === $current) {
                continue;
            } elseif ($status < 500 && $current < 500) {
                $current = 400;
            } else {
                $current = 500;
            }
        }

        return $current ?? 500;
    }

    /**
     * @param array<array-key, mixed> $headers
     */
    public function json(JsonApiDocumentInterface $document, int|null $statusCode = null, array $headers = []): JsonResponse
    {
        $content = $this->jsonApiSerializer->serialize($document);

        return $this->responseFactory->json($content, $statusCode ?? $this->detectStatus($content), $headers);
    }
}
