<?php

namespace App\Client\Resources\Meta;

use App\Dto\Region;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListRegionsRequest extends Request
{
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
