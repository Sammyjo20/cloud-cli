<?php

namespace App\Client\Resources\WebSocketClusters;

use App\Client\Requests\CreateWebSocketClusterRequestData;
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
        protected CreateWebSocketClusterRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/websocket-servers';
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): WebsocketCluster
    {
        return WebsocketCluster::createFromResponse($response->json());
    }
}
