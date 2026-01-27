<?php

namespace App\Client\Resources\DatabaseClusters;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListDatabaseTypesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/databases/types';
    }
}
