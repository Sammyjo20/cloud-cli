<?php

namespace App\Client\Resources\Meta;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\Region;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListRegionsRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/meta/regions';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return collect($response->json('data', []))->map(fn ($item) => Region::createFromResponse([
            'data' => $item,
            'included' => $response->json('included', []),
        ]))->all();
    }
}
