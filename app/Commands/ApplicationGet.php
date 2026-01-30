<?php

namespace App\Commands;

use function Laravel\Prompts\intro;

class ApplicationGet extends BaseCommand
{
    protected $signature = 'application:get {application? : The application ID or name} {--json : Output as JSON}';

    protected $description = 'Get application details';

    public function handle()
    {
        $this->ensureClient();

        intro('Application Details');

        $application = $this->resolvers()->application()->from($this->argument('application'));

        $this->outputJsonIfWanted($application);

        dataList([
            'Name' => $application->name,
            'ID' => $application->id,
            'Region' => $application->region,
            'Repository' => 'https://github.com/'.$application->repositoryFullName,
            'Environments' => collect($application->environments)->map(fn ($env) => $env->name.' '.$this->dim($env->id).'')->toArray(),
            'Organization' => $application->organization->name.' '.$this->dim($application->organization->id).'',
        ]);
    }
}
