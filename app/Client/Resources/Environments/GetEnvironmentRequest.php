<?php

namespace App\Client\Resources\Environments;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\Environment;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEnvironmentRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $environmentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Environment::createFromResponse($response->json());
    }
}
