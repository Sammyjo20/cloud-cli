<?php

namespace App\Client\Resources\Caches;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCachesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?string $include = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/caches';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'include' => $this->include,
        ]);
    }
}
