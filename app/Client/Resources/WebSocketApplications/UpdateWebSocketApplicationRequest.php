<?php

namespace App\Client\Resources\WebSocketApplications;

use App\Client\Requests\UpdateWebSocketApplicationRequestData;
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
        protected UpdateWebSocketApplicationRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-servers/{$this->data->clusterId}/applications/{$this->data->applicationId}";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): WebsocketApplication
    {
        return WebsocketApplication::createFromResponse($response->json());
    }
}
