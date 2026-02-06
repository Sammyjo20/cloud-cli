<?php

namespace App\Client\Requests;

class UpdateDatabaseClusterRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $clusterId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
