<?php

namespace App\Client\Resources\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteDomainRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $domainId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/domains/{$this->domainId}";
    }
}
