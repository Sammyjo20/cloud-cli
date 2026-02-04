<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\ObjectStorageBucket;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetObjectStorageBucketRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $bucketId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return ObjectStorageBucket::createFromResponse($response->json());
    }
}
