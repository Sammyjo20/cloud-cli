<?php

namespace App\Client\Requests;

class UpdateDomainRequestData extends RequestData
{
    public function __construct(
        public readonly string $domainId,
        public readonly string $verificationMethod,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'verification_method' => $this->verificationMethod,
        ];
    }
}
