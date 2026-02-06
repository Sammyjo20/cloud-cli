<?php

namespace App\Client\Requests;

class CreateCacheRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly string $region,
        public readonly array $configData,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'region' => $this->region,
            'config' => $this->configData,
        ];
    }
}
