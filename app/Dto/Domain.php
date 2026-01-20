<?php

namespace App\Dto;

use Carbon\CarbonImmutable;
use Illuminate\Http\Client\Response;

class Domain
{
    public function __construct(
        public readonly string $id,
        public readonly string $domain,
        public readonly string $status,
        public readonly bool $isPrimary,
        public readonly ?string $verificationStatus = null,
        public readonly ?CarbonImmutable $createdAt = null,
        public readonly ?CarbonImmutable $updatedAt = null,
        public readonly ?string $environmentId = null,
    ) {
        //
    }

    public static function fromApiResponse(Response $response, ?array $item = null): self
    {
        $responseData = $response->json();
        $data = $item ?? ($responseData['data'] ?? $responseData);
        $included = $responseData['included'] ?? [];

        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];

        return new self(
            id: $data['id'],
            domain: $attributes['domain'] ?? '',
            status: $attributes['status'] ?? '',
            isPrimary: $attributes['is_primary'] ?? false,
            verificationStatus: $attributes['verification_status'] ?? null,
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            environmentId: $relationships['environment']['data']['id'] ?? null,
        );
    }
}
