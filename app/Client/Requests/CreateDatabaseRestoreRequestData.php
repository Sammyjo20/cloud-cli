<?php

namespace App\Client\Requests;

class CreateDatabaseRestoreRequestData implements RequestDataInterface
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
        return array_filter([
            'snapshot_id' => $this->snapshotId,
            'point_in_time' => $this->pointInTime,
        ]);
    }
}
