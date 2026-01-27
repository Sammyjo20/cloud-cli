<?php

namespace App\Commands;

use App\Concerns\HasAClient;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class InstanceList extends BaseCommand
{
    use HasAClient;

    protected $signature = 'instance:list {environment : The environment ID} {--json : Output as JSON}';

    protected $description = 'List all instances for an environment';

    public function handle()
    {
        $this->ensureClient();

        intro('Listing Instances');

        $instances = spin(
            fn () => $this->client->instances()->list($this->argument('environment')),
            'Fetching instances...',
        );

        $items = collect($instances->items());

        if ($this->option('json')) {
            $this->line(json_encode([
                'data' => $items->map(fn ($instance) => [
                    'id' => $instance->id,
                    'name' => $instance->name,
                    'type' => $instance->type,
                    'size' => $instance->size,
                    'scaling_type' => $instance->scalingType,
                    'min_replicas' => $instance->minReplicas,
                    'max_replicas' => $instance->maxReplicas,
                    'created_at' => $instance->createdAt?->toIso8601String(),
                ])->toArray(),
            ], JSON_PRETTY_PRINT));

            return;
        }

        if ($items->isEmpty()) {
            info('No instances found.');

            return;
        }

        table(
            ['ID', 'Name', 'Type', 'Size', 'Replicas'],
            $items->map(fn ($instance) => [
                $instance->id,
                $instance->name,
                $instance->type,
                $instance->size,
                "{$instance->minReplicas}-{$instance->maxReplicas}",
            ])->toArray(),
        );
    }
}
