<?php

namespace App\Client\Resources\Caches;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteCacheRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $cacheId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/caches/{$this->cacheId}";
    }
}
