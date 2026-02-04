<?php

namespace App\Commands;

use App\Concerns\Validates;

use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class DomainCreate extends BaseCommand
{
    use Validates;

    protected $signature = 'domain:create
                            {--environment= : The environment ID}
                            {--domain= : The domain name}
                            {--json : Output as JSON}';

    protected $description = 'Create a new domain';

    public function handle()
    {
        $this->ensureClient();

        intro('Creating Domain');

        $environment = $this->resolvers()->environment()->from($this->option('environment'));

        $domain = $this->loopUntilValid(fn () => $this->createDomain($environment->id));

        $this->outputJsonIfWanted($domain);

        success('Domain created');

        outro("Domain created: {$domain->domain}");
    }

    protected function createDomain(string $environmentId)
    {
        $this->addParam(
            'domain',
            fn ($resolver) => $resolver
                ->fromInput(fn (?string $value) => text(
                    label: 'Domain name',
                    default: $value ?? '',
                    placeholder: 'example.com',
                    required: true,
                ))
                ->nonInteractively(fn () => $this->option('domain')),
        );

        return spin(
            fn () => $this->client->domains()->create(
                $environmentId,
                $this->getParam('domain'),
            ),
            'Creating domain...',
        );
    }
}
