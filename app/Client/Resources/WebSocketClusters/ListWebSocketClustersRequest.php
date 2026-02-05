<?php

namespace App\Client\Resources\WebSocketClusters;

use App\Dto\WebsocketCluster;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListWebSocketClustersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/websocket-servers';
    }

    public function createDtoFromResponse(Response $response): array
    {
        $data = $response->json('data') ?? [];

        return array_map(fn(array $item) => WebsocketCluster::createFromResponse(['data' => $item]), $data);
    }
}
