<?php

namespace App\Client\Resources;

use App\Client\Resources\ObjectStorageBuckets\CreateObjectStorageBucketRequest;
use App\Client\Resources\ObjectStorageBuckets\DeleteObjectStorageBucketRequest;
use App\Client\Resources\ObjectStorageBuckets\GetObjectStorageBucketRequest;
use App\Client\Resources\ObjectStorageBuckets\ListObjectStorageBucketsRequest;
use App\Client\Resources\ObjectStorageBuckets\UpdateObjectStorageBucketRequest;
use App\Dto\ObjectStorageBucket;
use Saloon\PaginationPlugin\Paginator;

class ObjectStorageBucketsResource extends Resource
{
    public function list(?string $type = null, ?string $status = null, ?string $visibility = null): Paginator
    {
        $request = new ListObjectStorageBucketsRequest(
            type: $type,
            status: $status,
            visibility: $visibility,
        );

        return $this->paginate($request);
    }

    public function get(string $bucketId): ObjectStorageBucket
    {
        $request = new GetObjectStorageBucketRequest($bucketId);
        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function create(string $name, string $region, string $visibility, ?string $jurisdiction = null, ?array $allowedOrigins = null, ?string $keyName = null, ?string $keyPermission = null): ObjectStorageBucket
    {
        $request = new CreateObjectStorageBucketRequest(
            name: $name,
            region: $region,
            visibility: $visibility,
            jurisdiction: $jurisdiction,
            allowedOrigins: $allowedOrigins,
            keyName: $keyName,
            keyPermission: $keyPermission,
        );

        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function update(string $bucketId, array $data): ObjectStorageBucket
    {
        $request = new UpdateObjectStorageBucketRequest(
            bucketId: $bucketId,
            data: $data,
        );

        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function delete(string $bucketId): void
    {
        $this->send(new DeleteObjectStorageBucketRequest($bucketId));
    }
}
