<?php

namespace App\Client\Resources\WebSocketClusters;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateWebSocketClusterRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $clusterId,
        protected array $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-clusters/{$this->clusterId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
