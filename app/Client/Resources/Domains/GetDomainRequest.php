<?php

namespace App\Client\Resources\Domains;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\Domain;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetDomainRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $domainId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/domains/{$this->domainId}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Domain::createFromResponse($response->json());
    }
}
