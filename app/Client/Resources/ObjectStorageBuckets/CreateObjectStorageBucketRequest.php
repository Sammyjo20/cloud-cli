<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use App\Client\Requests\CreateObjectStorageBucketRequestData;
use App\Dto\ObjectStorageBucket;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateObjectStorageBucketRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateObjectStorageBucketRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/buckets';
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
