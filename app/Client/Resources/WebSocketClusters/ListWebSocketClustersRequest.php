<?php

namespace App\Client\Resources\WebSocketClusters;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListWebSocketClustersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/websocket-clusters';
    }
}
