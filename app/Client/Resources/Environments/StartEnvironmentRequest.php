<?php

namespace App\Client\Resources\Environments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class StartEnvironmentRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected string $environmentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/start";
    }
}
