<?php

namespace App\Client\Requests;

interface RequestDataInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toRequestData(): array;
}
