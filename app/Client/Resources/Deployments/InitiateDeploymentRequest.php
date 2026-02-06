<?php

namespace App\Client\Resources\Deployments;

use App\Client\Requests\InitiateDeploymentRequestData;
use App\Dto\Deployment;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class InitiateDeploymentRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected InitiateDeploymentRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->data->environmentId}/deployments";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Deployment::createFromResponse($response->json());
    }
}
