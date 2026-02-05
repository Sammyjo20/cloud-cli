<?php

namespace App\Client\Resources\WebSocketClusters;

use App\Dto\WebsocketCluster;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateWebSocketClusterRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $name,
        protected string $region,
        protected int $maxConnections,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/websocket-servers';
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
            'type' => 'reverb',
            'region' => $this->region,
            'max_connections' => $this->maxConnections,
        ];
    }

    public function createDtoFromResponse(Response $response): WebsocketCluster
    {
        return WebsocketCluster::createFromResponse($response->json());
    }
}
