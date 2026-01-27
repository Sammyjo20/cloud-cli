<?php

namespace App\Client\Resources\WebSocketClusters;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWebSocketClusterRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-clusters/{$this->clusterId}";
    }
}
