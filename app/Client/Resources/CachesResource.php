<?php

namespace App\Client\Resources;

use App\Client\Resources\Caches\CreateCacheRequest;
use App\Client\Resources\Caches\DeleteCacheRequest;
use App\Client\Resources\Caches\GetCacheRequest;
use App\Client\Resources\Caches\ListCachesRequest;
use App\Client\Resources\Caches\ListCacheTypesRequest;
use App\Client\Resources\Caches\UpdateCacheRequest;
use App\Dto\Cache;
use Saloon\PaginationPlugin\Paginator;

class CachesResource extends Resource
{
    public function list(): Paginator
    {
        $request = new ListCachesRequest;

        return $this->paginate($request);
    }

    public function get(string $cacheId): Cache
    {
        $request = new GetCacheRequest($cacheId);
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function create(string $type, string $name, string $region, array $config): Cache
    {
        $request = new CreateCacheRequest(
            type: $type,
            name: $name,
            region: $region,
            configData: $config,
        );
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function update(string $cacheId, array $data): Cache
    {
        $request = new UpdateCacheRequest(
            cacheId: $cacheId,
            data: $data,
        );
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function delete(string $cacheId): void
    {
        $this->send(new DeleteCacheRequest($cacheId));
    }

    public function types(): array
    {
        $response = $this->send(new ListCacheTypesRequest);

        return $response->json()['data'] ?? [];
    }
}
