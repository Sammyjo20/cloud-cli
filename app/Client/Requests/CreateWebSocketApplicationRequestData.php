<?php

namespace App\Client\Requests;

class CreateWebSocketApplicationRequestData implements RequestDataInterface
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
