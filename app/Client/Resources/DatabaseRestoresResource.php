<?php

namespace App\Client\Resources;

use App\Client\Resources\DatabaseRestores\CreateDatabaseRestoreRequest;
use App\Dto\DatabaseCluster;

class DatabaseRestoresResource extends Resource
{
    public function create(string $clusterId, ?string $snapshotId = null, ?string $pointInTime = null): DatabaseCluster
    {
        $request = new CreateDatabaseRestoreRequest(
            clusterId: $clusterId,
            snapshotId: $snapshotId,
            pointInTime: $pointInTime,
        );

        $response = $this->send($request);

        return $request->createDtoFromResponse($response);
    }
}
