<?php

namespace App\Client\Resources\WebSocketClusters;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\WebsocketCluster;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetWebSocketClusterRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-servers/{$this->clusterId}";
    }

    public function createDtoFromResponse(Response $response): WebsocketCluster
    {
        return WebsocketCluster::createFromResponse($response->json());
    }
}
