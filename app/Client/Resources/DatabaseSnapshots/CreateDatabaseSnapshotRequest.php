<?php

namespace App\Client\Resources\DatabaseSnapshots;

use App\Client\Requests\CreateDatabaseSnapshotRequestData;
use App\Dto\DatabaseSnapshot;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateDatabaseSnapshotRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateDatabaseSnapshotRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->data->clusterId}/snapshots";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): DatabaseSnapshot
    {
        return DatabaseSnapshot::createFromResponse($response->json());
    }
}
