<?php

namespace App\Client\Resources\Instances;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteInstanceRequest extends Request
{
    protected Method $method = Method::DELETE;

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
