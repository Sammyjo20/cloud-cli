<?php

namespace App\Client\Resources\Applications;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\Application;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetApplicationRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $applicationId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/applications/{$this->applicationId}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Application::createFromResponse($response->json());
    }
}
