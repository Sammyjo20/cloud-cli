<?php

namespace App\Client\Resources\WebSocketClusters;

use App\Client\Resources\Concerns\AcceptsInclude;
use Saloon\Enums\Method;
use Saloon\Http\Request;

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
        return "/websocket-clusters/{$this->clusterId}";
    }
}
