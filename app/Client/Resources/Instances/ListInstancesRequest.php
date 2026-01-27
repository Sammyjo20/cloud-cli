<?php

namespace App\Client\Resources\Instances;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListInstancesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $environmentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/instances";
    }
}
