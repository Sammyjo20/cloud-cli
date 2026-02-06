<?php

namespace App\Client\Requests;

class CreateDomainRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $environmentId,
        public readonly string $name,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'name' => $this->name,
            ...$this->data,
        ];
    }
}
