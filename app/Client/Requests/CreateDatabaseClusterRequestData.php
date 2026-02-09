<?php

namespace App\Client\Requests;

class CreateDatabaseClusterRequestData extends RequestData
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly string $region,
        public readonly array $clusterConfig,
        public readonly ?int $clusterId = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'type' => $this->type,
            'name' => $this->name,
            'region' => $this->region,
            'config' => $this->clusterConfig,
            'cluster_id' => $this->clusterId,
        ]);
    }
}
