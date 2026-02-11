<?php

namespace App\Client\Resources\DatabaseClusters;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\DatabaseType;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListDatabaseTypesRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/databases/types';
    }

    public function createDtoFromResponse(Response $response): array
    {
        $responseData = $response->json();

        return array_map(fn ($item) => DatabaseType::createFromResponse([
            'data' => $item,
            'included' => $responseData['included'] ?? [],
        ]), $responseData['data'] ?? []);
    }
}
