<?php

namespace App\Client\Requests;

class UpdateBucketKeyRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $bucketId,
        public readonly string $keyId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
