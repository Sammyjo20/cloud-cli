<?php

namespace App\Client\Requests;

class CreateWebSocketClusterRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $region,
        public readonly int $maxConnections,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'name' => $this->name,
            'type' => 'reverb',
            'region' => $this->region,
            'max_connections' => $this->maxConnections,
        ];
    }
}
