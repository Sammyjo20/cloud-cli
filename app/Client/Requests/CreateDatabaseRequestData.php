<?php

namespace App\Client\Requests;

class CreateDatabaseRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $clusterId,
        public readonly string $name,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
