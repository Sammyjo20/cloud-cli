<?php

namespace App\Client\Requests;

class UpdateWebSocketClusterRequestData extends RequestData
{
    public function __construct(
        public readonly string $clusterId,
        public readonly ?string $name = null,
        public readonly ?int $maxConnections = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
            'max_connections' => $this->maxConnections,
        ]);
    }
}
