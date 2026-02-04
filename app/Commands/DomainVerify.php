<?php

namespace App\Commands;

use Illuminate\Http\Client\RequestException;

use function Laravel\Prompts\error;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;

class DomainVerify extends BaseCommand
{
    protected $signature = 'domain:verify {domain : The domain ID} {--json : Output as JSON}';

    protected $description = 'Verify domain DNS records are properly set up';

    public function handle()
    {
        $this->ensureClient();

        intro('Verifying Domain');

        try {
            spin(
                fn () => $this->client->domains()->verify($this->argument('domain')),
                'Verifying domain...',
            );

            $this->outputJsonIfWanted('Domain verification completed.');

            success('Domain verification completed.');
        } catch (RequestException $e) {
            error('Failed to verify domain: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
