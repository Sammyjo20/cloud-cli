<?php

namespace App\Commands;

use App\Dto\Database;
use Throwable;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;

class DatabaseDelete extends BaseCommand
{
    protected $signature = 'database:delete
                            {database-cluster? : The database cluster ID or name}
                            {database? : The database (schema) ID or name}
                            {--force : Skip confirmation}
                            {--json : Output as JSON}';

    protected $description = 'Delete a database (schema) from a database cluster';

    public function handle()
    {
        $this->ensureClient();

        intro('Deleting Database');

        $cluster = $this->resolvers()->databaseCluster()->from($this->argument('database-cluster'));

        $database = $this->resolveDatabase($cluster->schemas, $this->argument('database'));

        if (! $this->option('force') && ! confirm("Delete database '{$database->name}'?")) {
            info('Cancelled.');

            return self::SUCCESS;
        }

        try {
            spin(
                fn () => $this->client->databases()->delete($cluster->id, $database->id),
                'Deleting database...',
            );

            $this->outputJsonIfWanted('Database deleted.');

            success('Database deleted.');
        } catch (Throwable $e) {
            error('Failed to delete database: '.$e->getMessage());

            return self::FAILURE;
        }
    }

    protected function resolveDatabase(array $schemas, ?string $identifier): Database
    {
        $collection = collect($schemas);

        if ($identifier) {
            $database = $collection->firstWhere('id', $identifier)
                ?? $collection->firstWhere('name', $identifier);

            if ($database) {
                return $database instanceof Database ? $database : Database::from((array) $database);
            }

            $this->failAndExit("Database '{$identifier}' not found in this cluster.");
        }

        if ($collection->isEmpty()) {
            $this->failAndExit('No databases in this cluster.');
        }

        if ($collection->hasSole()) {
            $sole = $collection->first();

            return $sole instanceof Database ? $sole : Database::from((array) $sole);
        }

        $this->ensureInteractive('Please provide a database (schema) ID or name.');

        $selected = selectWithContext(
            label: 'Database',
            options: $collection->mapWithKeys(fn ($db) => [
                $db->id => $db->name,
            ])->toArray(),
        );

        $resolved = $collection->firstWhere('id', $selected);

        return $resolved instanceof Database ? $resolved : Database::from((array) $resolved);
    }
}
