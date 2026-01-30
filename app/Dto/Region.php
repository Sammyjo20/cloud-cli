<?php

namespace App\Dto;

use App\Concerns\HasDescriptiveArray;
use Spatie\LaravelData\Data;

class Region extends Data
{
    use HasDescriptiveArray;

    public function __construct(
        public readonly string $value,
        public readonly string $label,
        public readonly string $flag,
    ) {
        //
    }

    public static function createFromResponse(array $response): self
    {
        $data = $response['data'] ?? [];

        return self::from([
            'value' => $data['region'],
            'label' => $data['label'],
            'flag' => $data['flag'],
        ]);
    }
}
