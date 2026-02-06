<?php

namespace App\Client\Resources\Environments;

use App\Client\Requests\StartEnvironmentRequestData;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class StartEnvironmentRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected StartEnvironmentRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->data->environmentId}/start";
    }
}
