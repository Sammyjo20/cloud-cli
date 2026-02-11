<?php

namespace App\Client\Requests;

class CreateDatabaseRestoreRequestData extends RequestData
{
    public function __construct(
        public readonly string $clusterId,
        public readonly string $name,
        public readonly ?string $restoreTime = null,
        public readonly ?string $databaseSnapshotId = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
            'restore_time' => $this->restoreTime,
            'database_snapshot_id' => $this->databaseSnapshotId,
        ]);
    }
}
