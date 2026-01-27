<?php

namespace App\Commands;

use App\Concerns\HasAClient;
use App\Dto\Application;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class ApplicationList extends BaseCommand
{
    use HasAClient;

    protected $signature = 'application:list {--json : Output as JSON}';

    protected $description = 'List all applications';

    public function handle()
    {
        $this->ensureClient();

        intro('Applications');

        answered('Organization', $this->client->meta()->organization()->name);

        $applications = spin(
            fn () => $this->client->applications()->include('organization', 'environments')->list(),
            'Fetching applications...',
        );

        $items = $applications->collect();

        $this->outputJsonIfWanted($items);

        if ($items->isEmpty()) {
            info('No applications found.');

            return;
        }

        table(
            ['ID', 'Name', 'Region', 'Repository'],
            $items->map(fn (Application $app) => [
                $app->id,
                $app->name,
                $app->region,
                $app->repositoryFullName ?? 'N/A',
            ])->toArray(),
        );
    }
}
