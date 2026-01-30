<?php

namespace App\Commands;

use App\Concerns\HasAClient;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;

class BackgroundProcessGet extends BaseCommand
{
    use HasAClient;

    protected $signature = 'background-process:get {process? : The background process ID} {--json : Output as JSON}';

    protected $description = 'Get background process details';

    public function handle()
    {
        $this->ensureClient();

        intro('Background Process Details');

        $process = $this->resolvers()->backgroundProcess()->from($this->argument('process'));

        $this->outputJsonIfWanted($process);

        info("Background Process: {$process->id}");

        dataList($process->descriptiveArray());
    }
}
