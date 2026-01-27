<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateObjectStorageBucketRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $bucketId,
        protected array $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
