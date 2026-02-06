<?php

namespace App\Client\Requests;

class StopEnvironmentRequestData implements RequestDataInterface
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
