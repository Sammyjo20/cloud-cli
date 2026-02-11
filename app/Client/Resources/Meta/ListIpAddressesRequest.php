<?php

namespace App\Client\Resources\Meta;

use App\Client\Resources\Concerns\AcceptsInclude;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListIpAddressesRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/ip';
    }
}
