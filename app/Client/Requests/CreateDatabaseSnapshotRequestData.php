<?php

namespace App\Client\Requests;

class CreateDatabaseSnapshotRequestData implements RequestDataInterface
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
