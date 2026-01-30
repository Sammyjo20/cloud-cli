<?php

namespace App\Commands;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class EnvironmentList extends BaseCommand
{
    protected $signature = 'environment:list
                            {application? : The application ID or name}
                            {--json : Output as JSON}';

    protected $description = 'List all environments for an application';

    public function handle()
    {
        $this->ensureClient();

        intro('Environments');

        $application = $this->resolvers()->application()->from($this->argument('application'));

        answered('Application', $application->name);

        $environments = spin(
            fn () => $this->client->environments()->list($application->id),
            'Fetching environments...',
        );

        $envItems = $environments->collect();

        $this->outputJsonIfWanted($envItems);

        if ($envItems->isEmpty()) {
            info('No environments found.');

            return;
        }

        table(
            ['ID', 'Name', 'Branch', 'Status', 'URL'],
            $envItems->map(fn ($env) => [
                $env->id,
                $env->name,
                $env->branch ?? 'N/A',
                $env->status ?? 'N/A',
                $env->url ?: 'N/A',
            ])->toArray(),
        );
    }
}
