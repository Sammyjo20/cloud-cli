<?php

namespace App\Client\Resources\WebSocketClusters;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateWebSocketClusterRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $name,
        protected string $region,
        protected array $config,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/websocket-clusters';
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
            'region' => $this->region,
            'config' => $this->config,
        ];
    }
}
