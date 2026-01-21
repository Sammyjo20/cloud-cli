<?php

namespace App\Commands;

use Laravel\Prompts\Concerns\Colors;
use LaravelZero\Framework\Commands\Command;

use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;

abstract class BaseCommand extends Command
{
    use Colors;

    protected function intro(string $title, ?string $suffix = null): void
    {
        if ($this->hasOption('json') && $this->option('json')) {
            return;
        }

        if ($suffix) {
            $title .= ': '.$suffix;
        }

        intro($title);
    }

    protected function outro(string $title): void
    {
        if ($this->hasOption('json') && $this->option('json')) {
            return;
        }

        outro($title);
    }
}
