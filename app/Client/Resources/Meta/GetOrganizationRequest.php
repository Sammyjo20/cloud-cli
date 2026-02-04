<?php

namespace App\Client\Resources\Meta;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\Organization;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOrganizationRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/meta/organization';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Organization::createFromResponse($response->json());
    }
}
