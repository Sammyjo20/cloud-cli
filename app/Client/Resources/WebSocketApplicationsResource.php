<?php

namespace App\Client\Resources;

use App\Client\Requests\CreateWebSocketApplicationRequestData;
use App\Client\Requests\UpdateWebSocketApplicationRequestData;
use App\Client\Resources\WebSocketApplications\CreateWebSocketApplicationRequest;
use App\Client\Resources\WebSocketApplications\DeleteWebSocketApplicationRequest;
use App\Client\Resources\WebSocketApplications\GetWebSocketApplicationRequest;
use App\Client\Resources\WebSocketApplications\ListWebSocketApplicationsRequest;
use App\Client\Resources\WebSocketApplications\UpdateWebSocketApplicationRequest;
use App\Dto\WebsocketApplication;
use Saloon\PaginationPlugin\Paginator;

class WebSocketApplicationsResource extends Resource
{
    public function list(string $clusterId): Paginator
    {
        $request = new ListWebSocketApplicationsRequest($clusterId);

        return $this->paginate($request);
    }

    public function get(string $clusterId, string $applicationId): WebsocketApplication
    {
        $request = new GetWebSocketApplicationRequest(
            clusterId: $clusterId,
            applicationId: $applicationId,
        );
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function create(string $clusterId, array $data): WebsocketApplication
    {
        $request = new CreateWebSocketApplicationRequest(new CreateWebSocketApplicationRequestData(
            clusterId: $clusterId,
            data: $data,
        ));
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function update(string $clusterId, string $applicationId, array $data): WebsocketApplication
    {
        $request = new UpdateWebSocketApplicationRequest(new UpdateWebSocketApplicationRequestData(
            clusterId: $clusterId,
            applicationId: $applicationId,
            data: $data,
        ));
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function delete(string $clusterId, string $applicationId): void
    {
        $this->send(new DeleteWebSocketApplicationRequest(
            clusterId: $clusterId,
            applicationId: $applicationId,
        ));
    }
}
