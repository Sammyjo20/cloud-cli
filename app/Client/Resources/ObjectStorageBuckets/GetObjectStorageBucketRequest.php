<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetObjectStorageBucketRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $bucketId,
        protected ?string $include = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'include' => $this->include,
        ]);
    }
}
