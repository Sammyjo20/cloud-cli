<?php

namespace App\Client\Resources\BackgroundProcesses;

use App\Client\Requests\UpdateBackgroundProcessRequestData;
use App\Dto\BackgroundProcess;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateBackgroundProcessRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateBackgroundProcessRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/background-processes/{$this->data->backgroundProcessId}";
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
