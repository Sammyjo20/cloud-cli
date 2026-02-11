<?php

namespace App\Client\Resources\Instances;

use App\Client\Resources\Concerns\AcceptsInclude;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListInstanceSizesRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/instances/sizes';
    }
}
