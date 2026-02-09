<?php

namespace App\Client\Requests;

class CreateAuthSessionRequestData extends RequestData
{
    public function __construct(
        public readonly int $port,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'port' => $this->port,
        ];
    }
}
