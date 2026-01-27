<?php

namespace App\Client\Resources\Commands;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCommandRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $commandId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/commands/{$this->commandId}";
    }
}
