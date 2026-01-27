<?php

namespace App\Client\Resources\BackgroundProcesses;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListBackgroundProcessesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $instanceId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/instances/{$this->instanceId}/background-processes";
    }
}
