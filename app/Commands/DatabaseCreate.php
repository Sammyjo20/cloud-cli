<?php

namespace App\Commands;

use Illuminate\Http\Client\RequestException;

use function Laravel\Prompts\error;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class DatabaseCreate extends BaseCommand
{
    protected $signature = 'database:create
                            {database-cluster? : The database cluster ID or name}
                            {--name= : Database (schema) name}
                            {--json : Output as JSON}';

    protected $description = 'Create a new database (schema) in a database cluster';

    public function handle()
    {
        $this->ensureClient();

        intro('Create Database');

        $cluster = $this->resolvers()->databaseCluster()->from($this->argument('database-cluster'));

        $name = $this->option('name');

        if (! $name && ! $this->isInteractive()) {
            $this->failAndExit('Provide --name when non-interactive.');
        }

        $name ??= text(
            label: 'Database name',
            placeholder: 'my_database',
            required: true,
            validate: fn (string $value) => match (true) {
                ! preg_match('/^[a-z0-9_-]+$/', $value) => 'Must contain only lowercase letters, numbers, hyphens and underscores',
                strlen($value) < 3 => 'Must be at least 3 characters',
                strlen($value) > 40 => 'Must be less than 40 characters',
                default => null,
            },
        );

        try {
            $database = spin(
                fn () => $this->client->databases()->create($cluster->id, $name),
                'Creating database...',
            );

            $this->outputJsonIfWanted($database);

            success('Database created');

            outro("Database created: {$database->name}");
        } catch (RequestException $e) {
            if ($e->response?->status() === 422) {
                $errors = $e->response->json()['errors'] ?? [];
                foreach ($errors as $field => $messages) {
                    error(ucwords(str_replace('_', ' ', $field)).': '.implode(', ', (array) $messages));
                }
            } else {
                error('Failed to create database: '.$e->getMessage());
            }

            return self::FAILURE;
        }
    }
}
