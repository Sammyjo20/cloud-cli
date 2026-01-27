<?php

namespace App\Client;

use App\Client\Resources\Applications\CreateApplicationRequest;
use App\Client\Resources\Applications\GetApplicationRequest;
use App\Client\Resources\Applications\ListApplicationsRequest;
use App\Client\Resources\Applications\UpdateApplicationRequest;
use App\Dto\Application;
use App\Dto\Paginated;

class ApplicationsResource
{
    public function __construct(
        protected Connector $connector,
    ) {
        //
    }

    public function list(?string $include = null, ?string $name = null, ?string $region = null, ?string $slug = null): Paginated
    {
        $response = $this->connector->send(new ListApplicationsRequest(
            include: $include,
            name: $name,
            region: $region,
            slug: $slug,
        ));

        return ResponseMapper::mapPaginated($response->json(), fn ($response, $item) => ResponseMapper::mapApplication($response, $item));
    }

    public function get(string $applicationId, ?string $include = null): Application
    {
        $response = $this->connector->send(new GetApplicationRequest(
            applicationId: $applicationId,
            include: $include,
        ));

        return ResponseMapper::mapApplication($response->json());
    }

    public function create(string $repository, string $name, string $region): Application
    {
        $response = $this->connector->send(new CreateApplicationRequest(
            repository: $repository,
            name: $name,
            region: $region,
        ));

        return ResponseMapper::mapApplication($response->json());
    }

    public function update(string $applicationId, array $data): Application
    {
        $response = $this->connector->send(new UpdateApplicationRequest(
            applicationId: $applicationId,
            ...$data,
        ));

        return ResponseMapper::mapApplication($response->json());
    }
}
