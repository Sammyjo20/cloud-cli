<?php

namespace App\Client\Resources\Instances;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetInstanceRequest extends Request
{
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
}
