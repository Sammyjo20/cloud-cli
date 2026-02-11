<?php

namespace App\Dto;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class BackgroundProcess extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly int $processes,
        public readonly string $command,
        /** @var array<string, mixed>|null */
        public readonly ?array $config = null,
        public readonly ?string $strategyType = null,
        public readonly ?int $strategyThreshold = null,
        #[WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class)]
        public readonly ?CarbonImmutable $createdAt = null,
        public readonly ?string $instanceId = null,
        public readonly ?string $queue = null,
        public readonly ?string $connection = null,
        public readonly ?int $timeout = null,
        public readonly ?int $sleep = null,
        public readonly ?int $tries = null,
        public readonly ?int $backoff = null,
        public readonly ?int $rest = null,
        public readonly ?bool $force = null,
    ) {
        //
    }

    public static function createFromResponse(array $response): self
    {
        $data = $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];
        $config = $attributes['config'] ?? [];
        $config = is_array($config) ? $config : [];

        $transformed = [
            'id' => $data['id'],
            'type' => $attributes['type'] ?? 'worker',
            'processes' => $attributes['processes'] ?? 1,
            'command' => $attributes['command'] ?? '',
            'config' => $config ?: null,
            'strategyType' => $attributes['strategy_type'] ?? null,
            'strategyThreshold' => $attributes['strategy_threshold'] ?? null,
            'createdAt' => $attributes['created_at'] ?? null,
            'queue' => $config['queue'] ?? null,
            'connection' => $config['connection'] ?? null,
            'timeout' => isset($config['timeout']) ? (int) $config['timeout'] : null,
            'sleep' => isset($config['sleep']) ? (int) $config['sleep'] : null,
            'tries' => isset($config['tries']) ? (int) $config['tries'] : null,
            'backoff' => isset($config['backoff']) ? (int) $config['backoff'] : null,
            'rest' => isset($config['rest']) ? (int) $config['rest'] : null,
            'force' => isset($config['force']) ? (bool) $config['force'] : null,
        ];

        if (isset($relationships['instance']['data']['id'])) {
            $transformed['instanceId'] = $relationships['instance']['data']['id'];
        }

        return self::from($transformed);
    }
}
