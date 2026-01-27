<?php

namespace App\Client\Resources\Deployments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class InitiateDeploymentRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected string $environmentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/deployments";
    }
}
