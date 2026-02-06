<?php

namespace App\Client\Requests;

class CreateInstanceRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $environmentId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
