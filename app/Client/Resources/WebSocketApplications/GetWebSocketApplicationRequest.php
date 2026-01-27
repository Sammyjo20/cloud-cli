<?php

namespace App\Client\Resources\WebSocketApplications;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWebSocketApplicationRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
        protected string $applicationId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-clusters/{$this->clusterId}/applications/{$this->applicationId}";
    }
}
