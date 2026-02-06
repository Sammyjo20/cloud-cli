<?php

namespace App\Concerns;

use App\Dto\WebsocketApplication;
use App\Dto\WebsocketCluster;

use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

trait CreatesWebSocketApplication
{
    protected function createWebSocketApplication(WebsocketCluster $cluster, array $defaults = []): WebsocketApplication
    {
        $this->addParam(
            'name',
            fn ($resolver) => $resolver->fromInput(
                fn (?string $value) => text(
                    label: 'Application name',
                    default: $value ?? $defaults['name'] ?? '',
                    required: true,
                ),
            ),
        );

        return spin(
            fn () => $this->client->websocketApplications()->create($cluster->id, ['name' => $this->getParam('name')]),
            'Creating WebSocket application...',
        );
    }
}
