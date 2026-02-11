<?php

namespace App\Client\Requests;

class ReplaceEnvironmentVariablesRequestData extends RequestData
{
    public function __construct(
        public readonly string $environmentId,
        public readonly ?string $content = null,
        /** @var array<string, string> */
        public readonly array $variables = [],
    ) {
        //
    }

    public function toRequestData(): array
    {
        $body = [];

        if ($this->content !== null) {
            $body['content'] = $this->content;
        }

        if ($this->variables !== []) {
            $body['variables'] = collect($this->variables)->map(fn ($value, $key) => [
                'key' => $key,
                'value' => $value,
            ])->values()->toArray();
        }

        return $body;
    }
}
