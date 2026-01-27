<?php

namespace App\Client\Resources\BucketKeys;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBucketKeyRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $bucketId,
        protected string $keyId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}/keys/{$this->keyId}";
    }
}
