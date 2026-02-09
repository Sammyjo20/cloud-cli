<?php

namespace App\Client\Requests;

class CreateEnvironmentRequestData extends RequestData
{
    public function __construct(
        public readonly string $applicationId,
        public readonly string $name,
        public readonly ?string $branch = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
            'branch' => $this->branch,
        ]);
    }
}
