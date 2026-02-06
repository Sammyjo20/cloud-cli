<?php

namespace App\Client\Resources\Environments;

use App\Client\Requests\AddEnvironmentVariablesRequestData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class AddEnvironmentVariablesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected AddEnvironmentVariablesRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->data->environmentId}/variables";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }
}
