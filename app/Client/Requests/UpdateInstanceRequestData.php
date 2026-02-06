<?php

namespace App\Client\Requests;

class UpdateInstanceRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $instanceId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
