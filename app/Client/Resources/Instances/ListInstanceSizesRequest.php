<?php

namespace App\Client\Resources\Instances;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListInstanceSizesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/instances/sizes';
    }
}
