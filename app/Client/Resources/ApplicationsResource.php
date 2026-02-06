<?php

namespace App\Client\Resources;

use App\Client\Requests\CreateApplicationRequestData;
use App\Client\Requests\UpdateApplicationRequestData;
use App\Client\Resources\Applications\CreateApplicationRequest;
use App\Client\Resources\Applications\GetApplicationRequest;
use App\Client\Resources\Applications\ListApplicationsRequest;
use App\Client\Resources\Applications\UpdateApplicationRequest;
use App\Dto\Application;
use Saloon\Data\MultipartValue;
use Saloon\PaginationPlugin\Paginator;

class ApplicationsResource extends Resource
{
    public function list(?string $name = null, ?string $region = null, ?string $slug = null): Paginator
    {
        $request = new ListApplicationsRequest(
            name: $name,
            region: $region,
            slug: $slug,
        );

        return $this->paginate($request);
    }

    public function get(string $applicationId): Application
    {
        $request = new GetApplicationRequest($applicationId);
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function create(string $repository, string $name, string $region): Application
    {
        $request = new CreateApplicationRequest(new CreateApplicationRequestData(
            repository: $repository,
            name: $name,
            region: $region,
        ));

        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function update(string $applicationId, array $data): Application
    {
        $avatar = null;

        if (isset($data['avatar']) && is_array($data['avatar']) && count($data['avatar']) === 2) {
            [$avatarContent, $extension] = $data['avatar'];

            $avatar = new MultipartValue(
                name: 'avatar',
                value: $avatarContent,
                filename: 'avatar.'.$extension,
            );

            unset($data['avatar']);
        }

        $request = new UpdateApplicationRequest(new UpdateApplicationRequestData(
            applicationId: $applicationId,
            name: $data['name'] ?? null,
            slug: $data['slug'] ?? null,
            defaultEnvironmentId: $data['default_environment_id'] ?? null,
            repository: $data['repository'] ?? null,
            slackChannel: $data['slack_channel'] ?? null,
            avatar: $avatar,
        ));

        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function withDefaultIncludes(): static
    {
        return $this->include('organization', 'environments', 'defaultEnvironment');
    }
}
