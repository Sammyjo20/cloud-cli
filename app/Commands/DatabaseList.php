<?php

namespace App\Commands;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class DatabaseList extends BaseCommand
{
    protected $signature = 'database:list
                            {database-cluster? : The database cluster ID or name}
                            {--json : Output as JSON}';

    protected $description = 'List all databases (schemas) in a database cluster';

    public function handle()
    {
        $this->ensureClient();

        intro('Databases');

        $cluster = $this->resolvers()->databaseCluster()->from($this->argument('database-cluster'));

        $databases = spin(
            fn () => $this->client->databases()->list($cluster->id)->collect(),
            'Fetching databases...',
        );

        $this->outputJsonIfWanted($databases->toArray());

        if ($databases->isEmpty()) {
            info('No databases found.');

            return;
        }

        table(
            ['ID', 'Name', 'Created At'],
            $databases->map(fn ($database) => [
                $database->id,
                $database->name,
                $database->createdAt?->toIso8601String() ?? '-',
            ])->toArray(),
        );
    }
}
