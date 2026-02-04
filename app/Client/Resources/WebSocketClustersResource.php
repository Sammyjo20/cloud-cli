<?php

namespace App\Client\Resources;

use App\Client\Resources\WebSocketClusters\CreateWebSocketClusterRequest;
use App\Client\Resources\WebSocketClusters\DeleteWebSocketClusterRequest;
use App\Client\Resources\WebSocketClusters\GetWebSocketClusterRequest;
use App\Client\Resources\WebSocketClusters\ListWebSocketClustersRequest;
use App\Client\Resources\WebSocketClusters\UpdateWebSocketClusterRequest;
use App\Dto\WebsocketCluster;
use App\Enums\WebsocketServerConnectionDistributionStrategy;
use App\Enums\WebsocketServerMaxConnection;
use App\Enums\WebsocketServerStatus;
use App\Enums\WebsocketServerType;
use Carbon\CarbonImmutable;

class WebSocketClustersResource extends Resource
{
    public function list(): array
    {
        $response = $this->send(new ListWebSocketClustersRequest);

        $responseData = $response->json();

        return collect($responseData['data'] ?? [])->map(fn ($item) => new WebsocketCluster(
            id: $item['id'],
            name: $item['attributes']['name'],
            type: WebsocketServerType::from($item['attributes']['type']),
            region: $item['attributes']['region'],
            status: WebsocketServerStatus::from($item['attributes']['status']),
            maxConnections: WebsocketServerMaxConnection::from($item['attributes']['max_connections']),
            connectionDistributionStrategy: WebsocketServerConnectionDistributionStrategy::from($item['attributes']['connection_distribution_strategy']),
            hostname: $item['attributes']['hostname'],
            createdAt: isset($item['attributes']['created_at']) ? CarbonImmutable::parse($item['attributes']['created_at']) : null,
            applicationIds: array_column($item['relationships']['applications']['data'] ?? [], 'id'),
        ))->toArray();
    }

    public function get(string $clusterId): WebsocketCluster
    {
        $request = new GetWebSocketClusterRequest($clusterId);
        $response = $this->send($request);

        $data = $response->json()['data'];

        return new WebsocketCluster(
            id: $data['id'],
            name: $data['attributes']['name'],
            type: WebsocketServerType::from($data['attributes']['type']),
            region: $data['attributes']['region'],
            status: WebsocketServerStatus::from($data['attributes']['status']),
            maxConnections: WebsocketServerMaxConnection::from($data['attributes']['max_connections']),
            connectionDistributionStrategy: WebsocketServerConnectionDistributionStrategy::from($data['attributes']['connection_distribution_strategy']),
            hostname: $data['attributes']['hostname'],
            createdAt: isset($data['attributes']['created_at']) ? CarbonImmutable::parse($data['attributes']['created_at']) : null,
            applicationIds: array_column($data['relationships']['applications']['data'] ?? [], 'id'),
        );
    }

    public function create(string $name, string $region, array $config): WebsocketCluster
    {
        $response = $this->send(new CreateWebSocketClusterRequest(
            name: $name,
            region: $region,
            config: $config,
        ));

        $data = $response->json()['data'];

        return new WebsocketCluster(
            id: $data['id'],
            name: $data['attributes']['name'],
            type: WebsocketServerType::from($data['attributes']['type']),
            region: $data['attributes']['region'],
            status: WebsocketServerStatus::from($data['attributes']['status']),
            maxConnections: WebsocketServerMaxConnection::from($data['attributes']['max_connections']),
            connectionDistributionStrategy: WebsocketServerConnectionDistributionStrategy::from($data['attributes']['connection_distribution_strategy']),
            hostname: $data['attributes']['hostname'],
            createdAt: isset($data['attributes']['created_at']) ? CarbonImmutable::parse($data['attributes']['created_at']) : null,
            applicationIds: array_column($data['relationships']['applications']['data'] ?? [], 'id'),
        );
    }

    public function update(string $clusterId, array $data): WebsocketCluster
    {
        $response = $this->send(new UpdateWebSocketClusterRequest(
            clusterId: $clusterId,
            data: $data,
        ));

        $responseData = $response->json()['data'];

        return new WebsocketCluster(
            id: $responseData['id'],
            name: $responseData['attributes']['name'],
            type: WebsocketServerType::from($responseData['attributes']['type']),
            region: $responseData['attributes']['region'],
            status: WebsocketServerStatus::from($responseData['attributes']['status']),
            maxConnections: WebsocketServerMaxConnection::from($responseData['attributes']['max_connections']),
            connectionDistributionStrategy: WebsocketServerConnectionDistributionStrategy::from($responseData['attributes']['connection_distribution_strategy']),
            hostname: $responseData['attributes']['hostname'],
            createdAt: isset($responseData['attributes']['created_at']) ? CarbonImmutable::parse($responseData['attributes']['created_at']) : null,
            applicationIds: array_column($responseData['relationships']['applications']['data'] ?? [], 'id'),
        );
    }

    public function delete(string $clusterId): void
    {
        $this->send(new DeleteWebSocketClusterRequest($clusterId));
    }
}
