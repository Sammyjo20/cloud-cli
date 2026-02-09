<?php

namespace App\Client\Requests;

class UpdateBackgroundProcessRequestData extends RequestData
{
    public function __construct(
        public readonly string $backgroundProcessId,
        public readonly ?string $command = null,
        public readonly ?int $instances = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'command' => $this->command,
            'instances' => $this->instances,
        ]);
    }
}
