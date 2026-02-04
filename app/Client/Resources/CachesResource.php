<?php

namespace App\Client\Resources;

use App\Client\Resources\Caches\CreateCacheRequest;
use App\Client\Resources\Caches\DeleteCacheRequest;
use App\Client\Resources\Caches\GetCacheRequest;
use App\Client\Resources\Caches\ListCachesRequest;
use App\Client\Resources\Caches\ListCacheTypesRequest;
use App\Client\Resources\Caches\UpdateCacheRequest;

class CachesResource extends Resource
{
    public function list(): array
    {
        $response = $this->send(new ListCachesRequest);

        return $response->json()['data'] ?? [];
    }

    public function get(string $cacheId): array
    {
        $request = new GetCacheRequest($cacheId);
        $response = $this->send($request);

        return $response->json()['data'] ?? [];
    }

    public function create(string $type, string $name, string $region, array $config): array
    {
        $response = $this->send(new CreateCacheRequest(
            type: $type,
            name: $name,
            region: $region,
            config: $config,
        ));

        return $response->json()['data'] ?? [];
    }

    public function update(string $cacheId, array $data): array
    {
        $response = $this->send(new UpdateCacheRequest(
            cacheId: $cacheId,
            data: $data,
        ));

        return $response->json()['data'] ?? [];
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
