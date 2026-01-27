<?php

namespace App\Client\Resources\ObjectStorageBuckets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteObjectStorageBucketRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $bucketId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}";
    }
}
