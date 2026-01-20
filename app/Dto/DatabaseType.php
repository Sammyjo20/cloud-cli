<?php

namespace App\Dto;

use Illuminate\Http\Client\Response;

class DatabaseType
{
    public function __construct(
        public readonly string $type,
        public readonly string $label,
        public readonly array $regions,
        public readonly array $configSchema,
    ) {
        //
    }

    public static function fromApiResponse(Response $response, ?array $item = null): self
    {
        $responseData = $response->json();
        $data = $item ?? ($responseData['data'] ?? $responseData);
        $included = $responseData['included'] ?? [];

        return new self(
            type: $data['type'],
            label: $data['label'],
            regions: $data['regions'] ?? [],
            configSchema: array_map(
                fn (array $schema) => ConfigSchema::fromApiResponse($schema),
                $data['config_schema'] ?? []
            ),
        );
    }
}
