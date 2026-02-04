<?php

namespace App\Client\Resources;

use App\Client\Resources\BucketKeys\CreateBucketKeyRequest;
use App\Client\Resources\BucketKeys\DeleteBucketKeyRequest;
use App\Client\Resources\BucketKeys\GetBucketKeyRequest;
use App\Client\Resources\BucketKeys\ListBucketKeysRequest;
use App\Client\Resources\BucketKeys\UpdateBucketKeyRequest;

class BucketKeysResource extends Resource
{
    public function list(string $bucketId): array
    {
        $response = $this->send(new ListBucketKeysRequest($bucketId));

        return $response->json()['data'] ?? [];
    }

    public function get(string $bucketId, string $keyId): array
    {
        $request = new GetBucketKeyRequest(
            bucketId: $bucketId,
            keyId: $keyId,
        );
        $response = $this->send($request);

        return $response->json()['data'] ?? [];
    }

    public function create(string $bucketId, string $name, string $permission): array
    {
        $response = $this->send(new CreateBucketKeyRequest(
            bucketId: $bucketId,
            name: $name,
            permission: $permission,
        ));

        return $response->json()['data'] ?? [];
    }

    public function update(string $bucketId, string $keyId, array $data): array
    {
        $response = $this->send(new UpdateBucketKeyRequest(
            bucketId: $bucketId,
            keyId: $keyId,
            data: $data,
        ));

        return $response->json()['data'] ?? [];
    }

    public function delete(string $bucketId, string $keyId): void
    {
        $this->send(new DeleteBucketKeyRequest(
            bucketId: $bucketId,
            keyId: $keyId,
        ));
    }
}
