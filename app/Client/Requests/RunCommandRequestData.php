<?php

namespace App\Client\Requests;

class RunCommandRequestData extends RequestData
{
    public function __construct(
        public readonly string $environmentId,
        public readonly string $command,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'command' => $this->command,
        ];
    }
}
