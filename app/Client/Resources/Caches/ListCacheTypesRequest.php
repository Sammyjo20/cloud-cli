<?php

namespace App\Client\Resources\Caches;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCacheTypesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/caches/types';
    }
}
