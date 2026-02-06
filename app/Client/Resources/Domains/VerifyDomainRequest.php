<?php

namespace App\Client\Resources\Domains;

use App\Client\Requests\VerifyDomainRequestData;
use App\Dto\Domain;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class VerifyDomainRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected VerifyDomainRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/domains/{$this->data->domainId}/verify";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Domain::createFromResponse($response->json());
    }
}
