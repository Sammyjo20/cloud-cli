<?php

namespace App\Commands;

use Illuminate\Http\Client\RequestException;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\warning;

class DatabaseDelete extends BaseCommand
{
    protected $signature = 'database:delete {database? : The database ID or name} {--force : Skip confirmation} {--json : Output as JSON}';

    protected $description = 'Delete a database cluster';

    public function handle()
    {
        $this->ensureClient();

        intro('Deleting Database Cluster');

        if ($this->option('force') && ! $this->argument('database')) {
            warning('Force option provided but no database provided. Will still confirm deletion.');
        }

        $database = $this->resolvers()->databaseCluster()->from($this->argument('database'));
        $dontConfirm = $this->option('force') && $this->argument('database');

        if (! $dontConfirm && ! confirm('Delete database cluster?')) {
            error('Cancelled.');

            return self::FAILURE;
        }

        try {
            spin(
                fn () => $this->client->databaseClusters()->delete($database->id),
                'Deleting database cluster...',
            );

            $this->outputJsonIfWanted('Database cluster deleted.');

            success('Database cluster deleted.');

            return self::SUCCESS;
        } catch (RequestException $e) {
            error('Failed to delete database cluster: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
