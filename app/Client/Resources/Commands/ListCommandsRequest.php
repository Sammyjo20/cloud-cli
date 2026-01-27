<?php

namespace App\Client\Resources\Commands;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCommandsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $environmentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/commands";
    }
}
