<?php

namespace App\Commands;

use App\Concerns\HasAClient;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class BackgroundProcessList extends BaseCommand
{
    use HasAClient;

    protected $signature = 'background-process:list {instance : The instance ID} {--json : Output as JSON}';

    protected $description = 'List all background processes for an instance';

    public function handle()
    {
        $this->ensureClient();

        intro('Listing Background Processes');

        $processes = spin(
            fn () => $this->client->backgroundProcesses()->list($this->argument('instance')),
            'Fetching background processes...',
        );

        $items = collect($processes->items());

        if ($this->option('json')) {
            $this->line(json_encode([
                'data' => $items->map(fn ($process) => [
                    'id' => $process->id,
                    'command' => $process->command,
                    'type' => $process->type,
                    'instances' => $process->instances,
                    'created_at' => $process->createdAt?->toIso8601String(),
                ])->toArray(),
            ], JSON_PRETTY_PRINT));

            return;
        }

        if ($items->isEmpty()) {
            info('No background processes found.');

            return;
        }

        table(
            ['ID', 'Command', 'Type', 'Instances'],
            $items->map(fn ($process) => [
                $process->id,
                substr($process->command, 0, 50),
                $process->type,
                $process->instances,
            ])->toArray(),
        );
    }
}
