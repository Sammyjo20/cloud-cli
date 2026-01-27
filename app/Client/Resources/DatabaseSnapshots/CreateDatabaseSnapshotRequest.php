<?php

namespace App\Client\Resources\DatabaseSnapshots;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CreateDatabaseSnapshotRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected string $clusterId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->clusterId}/snapshots";
    }
}
