<?php

namespace App\Client\Resources\DatabaseSnapshots;

use App\Dto\DatabaseSnapshot;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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

    public function createDtoFromResponse(Response $response): DatabaseSnapshot
    {
        return DatabaseSnapshot::createFromResponse($response->json());
    }
}
