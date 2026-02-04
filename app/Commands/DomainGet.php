<?php

namespace App\Commands;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;

class DomainGet extends BaseCommand
{
    protected $signature = 'domain:get {domain : The domain ID} {--json : Output as JSON}';

    protected $description = 'Get domain details';

    public function handle()
    {
        $this->ensureClient();

        intro('Domain Details');

        $domain = spin(
            fn () => $this->client->domains()->get($this->argument('domain')),
            'Fetching domain...',
        );

        $this->outputJsonIfWanted($domain);

        info("Domain: {$domain->domain}");
        $this->line("ID: {$domain->id}");
        $this->line("Status: {$domain->status}");
        $this->line('Primary: '.($domain->isPrimary ? 'Yes' : 'No'));
        $this->line("Verification: {$domain->verificationStatus}");
    }
}
