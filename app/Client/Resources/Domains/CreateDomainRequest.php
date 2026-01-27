<?php

namespace App\Client\Resources\Domains;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateDomainRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $environmentId,
        protected string $domain,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/domains";
    }

    protected function defaultBody(): array
    {
        return [
            'domain' => $this->domain,
        ];
    }
}
