<?php

namespace App\Dto;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class CacheType extends Data
{
    public function __construct(
        public readonly string $type,
        public readonly string $label,
        public readonly array $regions,
        #[DataCollectionOf(CacheTypeSize::class)]
        public readonly array $sizes,
        public readonly bool $supportsAutoUpgrade,
    ) {
        //
    }

    public static function createFromResponse(array $response): self
    {
        $data = $response['data'] ?? [];

        return self::from([
            'type' => $data['type'] ?? '',
            'label' => $data['label'] ?? '',
            'regions' => $data['regions'] ?? [],
            'sizes' => $data['sizes'] ?? [],
            'supportsAutoUpgrade' => $data['supports_auto_upgrade'] ?? false,
        ]);
    }
}
