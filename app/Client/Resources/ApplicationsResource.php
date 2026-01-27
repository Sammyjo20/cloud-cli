<?php

namespace App\Client\Resources;

use App\Client\Connector;
use App\Client\Resources\Applications\CreateApplicationRequest;
use App\Client\Resources\Applications\GetApplicationRequest;
use App\Client\Resources\Applications\ListApplicationsRequest;
use App\Client\Resources\Applications\UpdateApplicationRequest;
use App\Client\Resources\Concerns\HasIncludes;
use App\Dto\Application;
use Saloon\Data\MultipartValue;
use Saloon\PaginationPlugin\Paginator;

class ApplicationsResource
{
    use HasIncludes;

    public function __construct(
        protected Connector $connector,
    ) {
        //
    }

    public function list(?string $name = null, ?string $region = null, ?string $slug = null): Paginator
    {
        $request = new ListApplicationsRequest(
            include: $this->getIncludesString(),
            name: $name,
            region: $region,
            slug: $slug,
        );

        return $this->connector->paginate($request);
    }

    public function get(string $applicationId): Application
    {
        $response = $this->connector->send(new GetApplicationRequest(
            applicationId: $applicationId,
            include: $this->getIncludesString(),
        ));

        return Application::createFromResponse($response->json());
    }

    public function create(string $repository, string $name, string $region): Application
    {
        $response = $this->connector->send(new CreateApplicationRequest(
            repository: $repository,
            name: $name,
            region: $region,
        ));

        return Application::createFromResponse($response->json());
    }

    public function update(string $applicationId, array $data): Application
    {
        $avatar = null;
        if (isset($data['avatar']) && is_array($data['avatar']) && count($data['avatar']) === 2) {
            [$avatarContent, $extension] = $data['avatar'];
            $avatar = new MultipartValue(
                value: $avatarContent,
                filename: 'avatar.'.$extension,
            );
            unset($data['avatar']);
        }

        $response = $this->connector->send(new UpdateApplicationRequest(
            applicationId: $applicationId,
            name: $data['name'] ?? null,
            slug: $data['slug'] ?? null,
            defaultEnvironmentId: $data['default_environment_id'] ?? null,
            repository: $data['repository'] ?? null,
            slackChannel: $data['slack_channel'] ?? null,
            avatar: $avatar,
        ));

        return Application::createFromResponse($response->json());
    }
}
