<?php

namespace App\Client\Resources\Caches;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCacheRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $cacheId,
        protected ?string $include = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/caches/{$this->cacheId}";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'include' => $this->include,
        ]);
    }
}
