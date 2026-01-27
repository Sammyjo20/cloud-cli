<?php

namespace App\Client\Resources\Deployments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDeploymentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $deploymentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/deployments/{$this->deploymentId}";
    }
}
