<?php

namespace App\Client\Requests;

class UpdateDomainRequestData extends RequestData
{
    public function __construct(
        public readonly string $domainId,
        public readonly ?string $verificationMethod = null,
        public readonly ?bool $isPrimary = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'verification_method' => $this->verificationMethod,
            'is_primary' => $this->isPrimary,
        ]);
    }
}
