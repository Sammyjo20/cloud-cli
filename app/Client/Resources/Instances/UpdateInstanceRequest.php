<?php

namespace App\Client\Resources\Instances;

use App\Client\Requests\UpdateInstanceRequestData;
use App\Dto\EnvironmentInstance;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateInstanceRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateInstanceRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/instances/{$this->data->instanceId}";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return EnvironmentInstance::createFromResponse($response->json());
    }
}
