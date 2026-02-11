<?php

namespace App\Client\Resources\DedicatedClusters;

use App\Client\Resources\Concerns\AcceptsInclude;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListDedicatedClustersRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/dedicated-clusters';
    }
}
