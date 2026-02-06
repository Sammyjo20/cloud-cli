<?php

namespace App\Client\Requests;

class RunCommandRequestData implements RequestDataInterface
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
