<?php

namespace App\Client\Requests;

class CreateApplicationRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $repository,
        public readonly string $name,
        public readonly string $region,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'repository' => $this->repository,
            'name' => $this->name,
            'region' => $this->region,
        ];
    }
}
