<?php

namespace App\Client\Resources\Databases;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\Database;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetDatabaseRequest extends Request
{
    use AcceptsInclude;

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

    public function createDtoFromResponse(Response $response): mixed
    {
        return Database::createFromResponse($response->json());
    }
}
