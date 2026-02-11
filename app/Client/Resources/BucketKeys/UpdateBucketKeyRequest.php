<?php

namespace App\Client\Resources\BucketKeys;

use App\Client\Requests\UpdateBucketKeyRequestData;
use App\Dto\BucketKey;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateBucketKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateBucketKeyRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/bucket-keys/{$this->data->filesystemKey}";
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
