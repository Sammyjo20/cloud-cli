<?php

namespace App\Client\Requests;

class CreateDatabaseRestoreRequestData extends RequestData
{
    public function __construct(
        public readonly string $clusterId,
        public readonly ?string $snapshotId = null,
        public readonly ?string $pointInTime = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'snapshot_id' => $this->snapshotId,
            'point_in_time' => $this->pointInTime,
        ]);
    }
}
