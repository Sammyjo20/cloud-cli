<?php

namespace App\Client\Resources\WebSocketApplications;

use App\Client\Requests\CreateWebSocketApplicationRequestData;
use App\Dto\WebsocketApplication;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateWebSocketApplicationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateWebSocketApplicationRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/websocket-servers/{$this->data->clusterId}/applications";
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
