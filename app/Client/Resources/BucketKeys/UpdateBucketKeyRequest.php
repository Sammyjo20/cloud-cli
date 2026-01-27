<?php

namespace App\Client\Resources\BucketKeys;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateBucketKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $bucketId,
        protected string $keyId,
        protected array $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}/keys/{$this->keyId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
