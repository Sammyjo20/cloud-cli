<?php

namespace App\Client\Requests;

class UpdateWebSocketApplicationRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $clusterId,
        public readonly string $applicationId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
