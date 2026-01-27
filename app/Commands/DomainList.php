<?php

namespace App\Commands;

use App\Concerns\HasAClient;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class DomainList extends BaseCommand
{
    use HasAClient;

    protected $signature = 'domain:list {environment : The environment ID} {--json : Output as JSON}';

    protected $description = 'List all domains for an environment';

    public function handle()
    {
        $this->ensureClient();

        intro('Listing Domains');

        $domains = spin(
            fn () => $this->client->domains()->list($this->argument('environment')),
            'Fetching domains...',
        );

        $items = collect($domains->items());

        if ($this->option('json')) {
            $this->line(json_encode([
                'data' => $items->map(fn ($domain) => [
                    'id' => $domain->id,
                    'domain' => $domain->domain,
                    'status' => $domain->status,
                    'is_primary' => $domain->isPrimary,
                    'verification_status' => $domain->verificationStatus,
                    'created_at' => $domain->createdAt?->toIso8601String(),
                ])->toArray(),
            ], JSON_PRETTY_PRINT));

            return;
        }

        if ($items->isEmpty()) {
            info('No domains found.');

            return;
        }

        table(
            ['ID', 'Domain', 'Status', 'Primary'],
            $items->map(fn ($domain) => [
                $domain->id,
                $domain->domain,
                $domain->status,
                $domain->isPrimary ? 'Yes' : 'No',
            ])->toArray(),
        );
    }
}
