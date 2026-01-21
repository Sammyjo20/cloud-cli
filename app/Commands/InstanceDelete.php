<?php

namespace App\Commands;

use App\Concerns\HasAClient;
use Illuminate\Http\Client\RequestException;
use Laravel\Prompts\Concerns\Colors;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\success;

class InstanceDelete extends BaseCommand
{
    use Colors;
    use HasAClient;

    protected $signature = 'instance:delete {instance : The instance ID} {--force : Skip confirmation}';

    protected $description = 'Delete an instance';

    public function handle()
    {
        $this->ensureClient();

        $this->intro('Deleting instance');

        $instanceId = $this->argument('instance');

        if (! $this->option('force')) {
            $instance = spin(
                fn () => $this->client->getInstance($instanceId),
                'Fetching instance...'
            );

            if (! confirm("Delete instance '{$instance->name}'?")) {
                info('Cancelled.');

                return;
            }
        }

        try {
            spin(
                fn () => $this->client->deleteInstance($instanceId),
                'Deleting instance...'
            );

            success('Instance deleted.');
        } catch (RequestException $e) {
            error('Failed to delete instance: '.$e->getMessage());

            return 1;
        }
    }
}
