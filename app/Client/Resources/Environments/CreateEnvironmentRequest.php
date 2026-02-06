<?php

namespace App\Client\Resources\Environments;

use App\Client\Requests\CreateEnvironmentRequestData;
use App\Dto\Environment;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateEnvironmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateEnvironmentRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/applications/{$this->data->applicationId}/environments";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Environment::createFromResponse($response->json());
    }
}
