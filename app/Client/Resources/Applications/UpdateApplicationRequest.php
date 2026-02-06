<?php

namespace App\Client\Resources\Applications;

use App\Client\Requests\UpdateApplicationRequestData;
use App\Dto\Application;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasMultipartBody;

class UpdateApplicationRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateApplicationRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/applications/{$this->data->applicationId}";
    }

    protected function defaultBody(): array
    {
        $body = $this->data->toRequestData();

        foreach ($body as $key => $value) {
            if (! $value instanceof MultipartValue) {
                $body[$key] = new MultipartValue(
                    name: $key,
                    value: $value,
                );
            }
        }

        return $body;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Application::createFromResponse($response->json());
    }
}
