<?php

namespace App\Client\Requests;

abstract class RequestData
{
    public function filter(array $array): array
    {
        return array_filter($array, fn ($value) => $value !== null);
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function toRequestData(): array;
}
