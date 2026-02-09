<?php

namespace App\Client\Requests;

class UpdateDatabaseClusterRequestData extends RequestData
{
    /**
     * @param  array<string, mixed>|null  $config
     */
    public function __construct(
        public readonly string $clusterId,
        public readonly ?array $config = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'config' => $this->config,
        ]);
    }
}
