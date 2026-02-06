<?php

namespace App\Client\Resources\BucketKeys;

use App\Client\Requests\CreateBucketKeyRequestData;
use App\Dto\BucketKey;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateBucketKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateBucketKeyRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->data->bucketId}/keys";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): BucketKey
    {
        return BucketKey::createFromResponse($response->json());
    }
}
