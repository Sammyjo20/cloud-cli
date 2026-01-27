<?php

namespace App\Client\Resources\DatabaseSnapshots;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDatabaseSnapshotRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clusterId,
        protected string $snapshotId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->clusterId}/snapshots/{$this->snapshotId}";
    }
}
