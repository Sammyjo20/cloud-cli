<?php

namespace App\Client\Resources\BucketKeys;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateBucketKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $bucketId,
        protected string $name,
        protected string $permission,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/buckets/{$this->bucketId}/keys";
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
            'permission' => $this->permission,
        ];
    }
}
