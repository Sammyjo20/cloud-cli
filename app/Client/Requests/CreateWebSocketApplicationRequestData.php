<?php

namespace App\Client\Requests;

class CreateWebSocketApplicationRequestData extends RequestData
{
    public function __construct(
        public readonly string $clusterId,
        public readonly ?string $name = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
        ]);
    }
}
