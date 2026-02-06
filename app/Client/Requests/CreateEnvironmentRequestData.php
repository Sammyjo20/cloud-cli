<?php

namespace App\Client\Requests;

class CreateEnvironmentRequestData implements RequestDataInterface
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
        return array_filter([
            'name' => $this->name,
            'branch' => $this->branch,
        ]);
    }
}
