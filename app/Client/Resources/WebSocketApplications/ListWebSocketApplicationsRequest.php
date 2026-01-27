<?php

namespace App\Client\Resources\WebSocketApplications;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListWebSocketApplicationsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-clusters/{$this->clusterId}/applications";
    }
}
