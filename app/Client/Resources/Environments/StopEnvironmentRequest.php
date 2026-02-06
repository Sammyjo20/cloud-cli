<?php

namespace App\Client\Resources\Environments;

use App\Client\Requests\StopEnvironmentRequestData;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class StopEnvironmentRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected StopEnvironmentRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->data->environmentId}/stop";
    }
}
