<?php

namespace App\Client\Requests;

class UpdateDomainRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $domainId,
        public readonly array $data,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->data;
    }
}
