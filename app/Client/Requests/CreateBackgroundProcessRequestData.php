<?php

namespace App\Client\Requests;

class CreateBackgroundProcessRequestData extends RequestData
{
    /**
     * @param  array{queue: string, connection: string, tries: int, backoff: int, sleep: int, rest: int, timeout: int, force: bool}  $config
     */
    public function __construct(
        public readonly string $instanceId,
        public readonly ?string $type = null,
        public readonly ?int $processes = null,
        public readonly ?string $command = null,
        public readonly ?array $config = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'type' => $this->type,
            'processes' => $this->processes,
            'command' => $this->command,
            'config' => $this->config,
        ]);
    }
}
