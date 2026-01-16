<?php

namespace App\Dto;

use Carbon\CarbonImmutable;

class Database
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $status,
        public readonly string $region,
        public readonly array $config,
        public readonly array $connection,
        public readonly ?CarbonImmutable $createdAt = null,
        public readonly array $schemas = [],
    ) {
        //
    }

    public static function fromApiResponse(array $data, array $response): self
    {
        $attributes = $data['attributes'] ?? [];
        $included = $response['included'] ?? [];

        return new self(
            id: $data['id'],
            name: $attributes['name'],
            type: $attributes['type'],
            status: $attributes['status'],
            region: $attributes['region'],
            config: $attributes['config'] ?? [],
            connection: $attributes['connection'] ?? [],
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            schemas: collect($included)
                ->filter(fn ($item) => $item['type'] === 'databaseSchemas')
                ->map(fn ($item) => [
                    'id' => $item['id'],
                    'name' => $item['attributes']['name'],
                ])
                ->values()
                ->toArray(),
        );
    }
}
