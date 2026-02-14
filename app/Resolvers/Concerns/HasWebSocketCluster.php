<?php

namespace App\Resolvers\Concerns;

use App\Dto\WebsocketCluster;

trait HasWebSocketCluster
{
    protected ?WebsocketCluster $websocketCluster = null;

    public function withCluster(null|string|WebsocketCluster $cluster): self
    {
        if (is_string($cluster)) {
            $cluster = $this->resolvers()->websocketCluster()->from($cluster);
        }

        $this->websocketCluster = $cluster;

        return $this;
    }

    protected function cluster(): WebsocketCluster
    {
        return $this->websocketCluster ??= $this->resolvers()->websocketCluster()->resolve();
    }
}
