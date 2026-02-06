<?php

namespace App\Client\Resources\BackgroundProcesses;

use App\Client\Requests\CreateBackgroundProcessRequestData;
use App\Dto\BackgroundProcess;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateBackgroundProcessRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateBackgroundProcessRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/instances/{$this->data->instanceId}/background-processes";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return BackgroundProcess::createFromResponse($response->json());
    }
}
