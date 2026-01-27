<?php

namespace App\Client\Resources\DatabaseClusters;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDatabaseClusterRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
        protected ?string $include = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->clusterId}";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'include' => $this->include,
        ]);
    }
}
