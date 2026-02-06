<?php

namespace App\Client\Requests;

class CreateBucketKeyRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $bucketId,
        public readonly string $name,
        public readonly string $permission,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'name' => $this->name,
            'permission' => $this->permission,
        ];
    }
}
