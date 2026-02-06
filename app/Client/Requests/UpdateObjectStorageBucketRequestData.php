<?php

namespace App\Client\Requests;

class UpdateObjectStorageBucketRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $bucketId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
