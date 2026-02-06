<?php

namespace App\Concerns;

use App\Dto\Region;
use App\Dto\WebsocketCluster;

use function Laravel\Prompts\number;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

trait CreatesWebSocketCluster
{
    protected function createWebSocketCluster(array $defaults = []): WebsocketCluster
    {
        $this->addParam(
            'name',
            fn ($resolver) => $resolver->fromInput(
                fn (?string $value) => text(
                    label: 'Cluster name',
                    default: $value ?? $defaults['name'] ?? '',
                    required: true,
                ),
            ),
        );

        $regions = spin(
            fn () => $this->client->meta()->regions(),
            'Fetching regions...',
        );

        $this->addParam(
            'region',
            fn ($resolver) => $resolver->fromInput(
                fn (?string $value) => select(
                    label: 'Region',
                    options: collect($regions)->mapWithKeys(fn (Region $r) => [$r->value => $r->label])->toArray(),
                    default: $value ?? $defaults['region'] ?? null,
                    required: true,
                ),
            ),
        );

        $this->addParam(
            'max_connections',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => number(
                    label: 'Max connections',
                    default: $value ?? $defaults['max_connections'] ?? 100,
                    required: true,
                ),
            ),
        );

        return spin(
            fn () => $this->client->websocketClusters()->create(
                $this->getParam('name'),
                $this->getParam('region'),
                (int) $this->getParam('max_connections'),
            ),
            'Creating WebSocket cluster...',
        );
    }
}
