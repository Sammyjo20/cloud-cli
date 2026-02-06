<?php

namespace App\Client\Requests;

class VerifyDomainRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $domainId,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [];
    }
}
