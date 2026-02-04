<?php

namespace App\Client\Resources\Instances;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\EnvironmentInstance;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetInstanceRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $instanceId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/instances/{$this->instanceId}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return EnvironmentInstance::createFromResponse($response->json());
    }
}
