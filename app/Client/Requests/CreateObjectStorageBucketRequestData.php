<?php

namespace App\Client\Requests;

class CreateObjectStorageBucketRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $region,
        public readonly string $visibility,
        public readonly ?string $jurisdiction = null,
        public readonly ?array $allowedOrigins = null,
        public readonly ?string $keyName = null,
        public readonly ?string $keyPermission = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return array_filter([
            'name' => $this->name,
            'region' => $this->region,
            'visibility' => $this->visibility,
            'jurisdiction' => $this->jurisdiction,
            'allowed_origins' => $this->allowedOrigins,
            'key_name' => $this->keyName,
            'key_permission' => $this->keyPermission,
        ]);
    }
}
