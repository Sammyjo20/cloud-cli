<?php

namespace App\Client\Resources;

use App\Client\Resources\WebSocketClusters\CreateWebSocketClusterRequest;
use App\Client\Resources\WebSocketClusters\DeleteWebSocketClusterRequest;
use App\Client\Resources\WebSocketClusters\GetWebSocketClusterRequest;
use App\Client\Resources\WebSocketClusters\ListWebSocketClustersRequest;
use App\Client\Resources\WebSocketClusters\UpdateWebSocketClusterRequest;
use App\Dto\WebsocketCluster;
use Saloon\PaginationPlugin\Paginator;

class WebSocketClustersResource extends Resource
{
    public function list(): Paginator
    {
        $request = new ListWebSocketClustersRequest;

        return $this->paginate($request);
    }

    public function get(string $clusterId): WebsocketCluster
    {
        $request = new GetWebSocketClusterRequest($clusterId);
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function create(string $name, string $region, int $maxConnections): WebsocketCluster
    {
        $request = new CreateWebSocketClusterRequest(
            name: $name,
            region: $region,
            maxConnections: $maxConnections,
        );
        $response = $this->send($request);

        $dto = $request->createDtoFromResponse($response);

        return $dto;
    }

    public function update(string $clusterId, array $data): WebsocketCluster
    {
        $request = new UpdateWebSocketClusterRequest(
            clusterId: $clusterId,
            data: $data,
        );
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function delete(string $clusterId): void
    {
        $this->send(new DeleteWebSocketClusterRequest($clusterId));
    }
}
