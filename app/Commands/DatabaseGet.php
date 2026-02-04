<?php

namespace App\Commands;

use App\Dto\Database;

use function Laravel\Prompts\intro;

class DatabaseGet extends BaseCommand
{
    protected $signature = 'database:get
                            {database-cluster? : The database cluster ID or name}
                            {database? : The database (schema) ID or name}
                            {--json : Output as JSON}';

    protected $description = 'Get database (schema) details';

    public function handle()
    {
        $this->ensureClient();

        intro('Database Details');

        $cluster = $this->resolvers()->databaseCluster()->from($this->argument('database-cluster'));

        $database = $this->resolveDatabase($cluster->schemas, $this->argument('database'));

        $this->outputJsonIfWanted([
            'id' => $database->id,
            'name' => $database->name,
            'created_at' => $database->createdAt?->toIso8601String(),
        ]);

        dataList([
            'ID' => $database->id,
            'Name' => $database->name,
            'Created At' => $database->createdAt?->toIso8601String() ?? '-',
        ]);
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
