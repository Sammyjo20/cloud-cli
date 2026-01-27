<?php

namespace App\Client\Resources\Databases;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDatabaseRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
        protected string $databaseId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->clusterId}/databases/{$this->databaseId}";
    }
}
