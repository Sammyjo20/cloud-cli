<?php

namespace App\Client\Resources;

use App\Client\Resources\DedicatedClusters\ListDedicatedClustersRequest;

class DedicatedClustersResource extends Resource
{
    public function list(): array
    {
        $response = $this->send(new ListDedicatedClustersRequest);

        return $response->json()['data'] ?? [];
    }
}
