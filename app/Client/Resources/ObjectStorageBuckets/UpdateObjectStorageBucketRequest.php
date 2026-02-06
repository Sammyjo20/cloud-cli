<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use App\Client\Requests\UpdateObjectStorageBucketRequestData;
use App\Dto\ObjectStorageBucket;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateObjectStorageBucketRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateObjectStorageBucketRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->data->bucketId}";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return ObjectStorageBucket::createFromResponse($response->json());
    }
}
