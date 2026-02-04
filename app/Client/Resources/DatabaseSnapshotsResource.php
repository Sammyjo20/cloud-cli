<?php

namespace App\Client\Resources;

use App\Client\Resources\DatabaseSnapshots\CreateDatabaseSnapshotRequest;
use App\Client\Resources\DatabaseSnapshots\DeleteDatabaseSnapshotRequest;
use App\Client\Resources\DatabaseSnapshots\GetDatabaseSnapshotRequest;
use App\Client\Resources\DatabaseSnapshots\ListDatabaseSnapshotsRequest;

class DatabaseSnapshotsResource extends Resource
{
    public function list(string $clusterId): array
    {
        $response = $this->send(new ListDatabaseSnapshotsRequest($clusterId));

        return $response->json()['data'] ?? [];
    }

    public function get(string $clusterId, string $snapshotId): array
    {
        $request = new GetDatabaseSnapshotRequest(
            clusterId: $clusterId,
            snapshotId: $snapshotId,
        );
        $response = $this->send($request);

        return $response->json()['data'] ?? [];
    }

    public function create(string $clusterId): array
    {
        $response = $this->send(new CreateDatabaseSnapshotRequest($clusterId));

        return $response->json()['data'] ?? [];
    }

    public function delete(string $clusterId, string $snapshotId): void
    {
        $this->send(new DeleteDatabaseSnapshotRequest(
            clusterId: $clusterId,
            snapshotId: $snapshotId,
        ));
    }
}
