<?php

namespace App\Client\Requests;

class UpdateCacheRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $cacheId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
