<?php

namespace App\Client\Requests;

class VerifyDomainRequestData extends RequestData
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
