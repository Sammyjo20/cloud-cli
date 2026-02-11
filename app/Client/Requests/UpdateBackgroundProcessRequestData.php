<?php

namespace App\Client\Requests;

class UpdateBackgroundProcessRequestData extends RequestData
{
    /**
     * @param  array{connection?: string, queue?: string, tries?: int, backoff?: int, sleep?: int, rest?: int, timeout?: int, force?: bool}|null  $config
     */
    public function __construct(
        public readonly string $backgroundProcessId,
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
