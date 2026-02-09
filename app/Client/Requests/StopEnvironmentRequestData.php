<?php

namespace App\Client\Requests;

class StopEnvironmentRequestData extends RequestData
{
    public function __construct(
        public readonly string $environmentId,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [];
    }
}
