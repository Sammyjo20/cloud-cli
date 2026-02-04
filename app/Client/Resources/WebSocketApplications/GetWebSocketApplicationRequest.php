<?php

namespace App\Client\Resources\WebSocketApplications;

use App\Client\Resources\Concerns\AcceptsInclude;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWebSocketApplicationRequest extends Request
{
    use AcceptsInclude;

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
