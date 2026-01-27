<?php

namespace App\Client\Resources\DatabaseClusters;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteDatabaseClusterRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $clusterId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->clusterId}";
    }
}
