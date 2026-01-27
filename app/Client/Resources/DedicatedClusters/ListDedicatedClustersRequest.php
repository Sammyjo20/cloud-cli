<?php

namespace App\Client\Resources\DedicatedClusters;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListDedicatedClustersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/dedicated-clusters';
    }
}
