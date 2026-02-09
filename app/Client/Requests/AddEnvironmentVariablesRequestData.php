<?php

namespace App\Client\Requests;

/**
 * @param  'append'|'set'  $action
 */
class AddEnvironmentVariablesRequestData extends RequestData
{
    public function __construct(
        public readonly string $environmentId,
        public readonly array $variables,
        public readonly string $action = 'append',
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'method' => $this->action,
            'variables' => collect($this->variables)->map(fn ($value, $key) => [
                'key' => $key,
                'value' => $value,
            ])->values()->toArray(),
        ];
    }
}
