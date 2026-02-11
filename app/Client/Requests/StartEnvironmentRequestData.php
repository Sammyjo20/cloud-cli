<?php

namespace App\Client\Requests;

class StartEnvironmentRequestData extends RequestData
{
    public function __construct(
        public readonly string $environmentId,
        public readonly ?bool $redeploy = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'redeploy' => $this->redeploy,
        ]);
    }
}
