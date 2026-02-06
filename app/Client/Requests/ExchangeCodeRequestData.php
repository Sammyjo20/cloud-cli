<?php

namespace App\Client\Requests;

class ExchangeCodeRequestData implements RequestDataInterface
{
    public function __construct(
        public readonly string $exchangeCode,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return [
            'exchange_code' => $this->exchangeCode,
        ];
    }
}
