<?php

namespace App\Client\Requests;

class CreateBucketKeyRequestData extends RequestData
{
    public function __construct(
        public readonly string $filesystemId,
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
