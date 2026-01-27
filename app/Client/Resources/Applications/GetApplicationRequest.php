<?php

namespace App\Client\Resources\Applications;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetApplicationRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $applicationId,
        protected ?string $include = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/applications/{$this->applicationId}";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'include' => $this->include,
        ]);
    }
}
