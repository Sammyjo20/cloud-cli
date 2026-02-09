<?php

namespace App\Client\Requests;

class CreateDatabaseSnapshotRequestData extends RequestData
{
    public function __construct(
        public readonly string $clusterId,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [];
    }
}
