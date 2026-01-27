<?php

namespace App\Client\Resources\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListDomainsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $environmentId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/domains";
    }
}
