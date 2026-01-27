<?php

namespace App\Commands;

use App\Concerns\HasAClient;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class CommandList extends BaseCommand
{
    use HasAClient;

    protected $signature = 'command:list {environment : The environment ID} {--json : Output as JSON}';

    protected $description = 'List all commands for an environment';

    public function handle()
    {
        $this->ensureClient();

        intro('Listing Commands');

        $commands = spin(
            fn () => $this->client->commands()->list($this->argument('environment')),
            'Fetching commands...',
        );

        $items = $commands->collect();

        if ($this->option('json')) {
            $this->line(json_encode([
                'data' => $items->map(fn ($cmd) => [
                    'id' => $cmd->id,
                    'command' => $cmd->command,
                    'status' => $cmd->status,
                    'exit_code' => $cmd->exitCode,
                    'started_at' => $cmd->startedAt?->toIso8601String(),
                    'finished_at' => $cmd->finishedAt?->toIso8601String(),
                ])->toArray(),
            ], JSON_PRETTY_PRINT));

            return;
        }

        if ($items->isEmpty()) {
            info('No commands found.');

            return;
        }

        table(
            ['ID', 'Command', 'Status', 'Exit Code', 'Started'],
            $items->map(fn ($cmd) => [
                $cmd->id,
                substr($cmd->command, 0, 50),
                $cmd->status,
                $cmd->exitCode ?? 'N/A',
                $cmd->startedAt?->format('Y-m-d H:i:s') ?? 'N/A',
            ])->toArray(),
        );
    }
}
