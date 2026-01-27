<?php

namespace App\Client\Resources\Meta;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListRegionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/meta/regions';
    }
}
