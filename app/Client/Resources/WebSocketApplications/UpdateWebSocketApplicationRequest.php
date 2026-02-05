<?php

namespace App\Client\Resources\WebSocketApplications;

use App\Dto\WebsocketApplication;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateWebSocketApplicationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $clusterId,
        protected string $applicationId,
        protected array $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-servers/{$this->clusterId}/applications/{$this->applicationId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }

    public function createDtoFromResponse(Response $response): WebsocketApplication
    {
        return WebsocketApplication::createFromResponse($response->json());
    }
}
