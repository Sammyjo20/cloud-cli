<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\ObjectStorageBucket;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class ListObjectStorageBucketsRequest extends Request implements Paginatable
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected ?string $type = null,
        protected ?string $status = null,
        protected ?string $visibility = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/buckets';
    }

    protected function defaultQuery(): array
    {
        return array_merge(
            $this->includeQuery(),
            array_filter([
                'filter[type]' => $this->type,
                'filter[status]' => $this->status,
                'filter[visibility]' => $this->visibility,
            ]),
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return array_map(fn ($bucket) => ObjectStorageBucket::createFromResponse([
            'data' => $bucket,
            'included' => $response->json('included', []),
        ]), $response->json('data'));
    }
}
