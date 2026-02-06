<?php

namespace App\Client\Resources\WebSocketClusters;

use App\Client\Requests\UpdateWebSocketClusterRequestData;
use App\Dto\WebsocketCluster;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateWebSocketClusterRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateWebSocketClusterRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-servers/{$this->data->clusterId}";
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
