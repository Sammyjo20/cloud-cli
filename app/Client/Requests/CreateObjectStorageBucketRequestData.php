<?php

namespace App\Client\Requests;

class CreateObjectStorageBucketRequestData extends RequestData
{
    public function __construct(
        public readonly string $name,
        public readonly string $visibility,
        public readonly string $jurisdiction,
        public readonly string $keyName,
        public readonly string $keyPermission,
        public readonly ?array $allowedOrigins = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
            'visibility' => $this->visibility,
            'jurisdiction' => $this->jurisdiction,
            'allowed_origins' => $this->allowedOrigins,
            'key_name' => $this->keyName,
            'key_permission' => $this->keyPermission,
        ]);
    }
}
