<?php

namespace App\Client\Requests;

class UpdateBackgroundProcessRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $backgroundProcessId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
