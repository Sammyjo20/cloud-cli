<?php

namespace App\Client\Requests;

class CreateDatabaseSnapshotRequestData extends RequestData
{
    public function __construct(
        public readonly string $clusterId,
        public readonly string $name,
        public readonly ?string $description = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }
}
