<?php

namespace App\Commands;

use App\Client\Requests\UpdateBackgroundProcessRequestData;
use App\Dto\BackgroundProcess;
use App\Exceptions\CommandExitException;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\number;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class BackgroundProcessUpdate extends BaseCommand
{
    protected $signature = 'background-process:update
                            {process? : The background process ID}
                            {--type= : Process type (worker|custom)}
                            {--command= : The command to run (custom type only)}
                            {--processes= : Number of processes (1-10)}
                            {--connection= : Queue connection (worker only)}
                            {--queue= : Queue name(s), comma-separated (worker only)}
                            {--tries= : Number of job attempts (worker only)}
                            {--backoff= : Seconds before retry (worker only)}
                            {--sleep= : Seconds to sleep when no jobs (worker only)}
                            {--rest= : Seconds to rest between jobs (worker only)}
                            {--timeout= : Job timeout in seconds (worker only)}
                            {--run-in-maintenance : Run in maintenance mode (worker only)}
                            {--force : Force update without confirmation}
                            {--json : Output as JSON}';

    protected $description = 'Update a background process';

    public function handle()
    {
        $this->ensureClient();

        intro('Updating Background Process');

        $process = $this->resolvers()->backgroundProcess()->from($this->argument('process'));

        $this->defineFields($process);

        foreach ($this->form()->filled() as $key => $value) {
            $this->reportChange(
                $value->label(),
                $value->previousValue(),
                $value->value(),
            );
        }

        $updatedProcess = $this->resolveUpdatedProcess($process);

        $this->outputJsonIfWanted($updatedProcess);

        success('Background process updated');

        outro("Background process updated: {$updatedProcess->id}");
    }

    protected function resolveUpdatedProcess(BackgroundProcess $process): BackgroundProcess
    {
        if (! $this->isInteractive()) {
            if (! $this->form()->hasAnyValues()) {
                $this->outputErrorOrThrow('No fields to update. Provide at least one option.');

                throw new CommandExitException(self::FAILURE);
            }

            return $this->updateProcess($process);
        }

        if (! $this->form()->hasAnyValues()) {
            return $this->loopUntilValid(
                fn () => $this->collectDataAndUpdate($process),
            );
        }

        if (! $this->shouldRunUpdateFromOptions()) {
            error('Update cancelled');

            throw new CommandExitException(self::FAILURE);
        }

        return $this->updateProcess($process);
    }

    protected function updateProcess(BackgroundProcess $process): BackgroundProcess
    {
        $processes = $this->form()->get('processes');
        $command = $this->form()->get('command');
        $config = $this->buildConfig($process);

        spin(
            fn () => $this->client->backgroundProcesses()->update(
                new UpdateBackgroundProcessRequestData(
                    backgroundProcessId: $process->id,
                    type: null,
                    processes: $processes !== null ? (int) $processes : null,
                    command: $command,
                    config: $config,
                ),
            ),
            'Updating background process...',
        );

        return $this->client->backgroundProcesses()->get($process->id);
    }

    /**
     * @return array{connection?: string, queue?: string, tries?: int, backoff?: int, sleep?: int, rest?: int, timeout?: int, force?: bool}|null
     */
    protected function buildConfig(BackgroundProcess $process): ?array
    {
        if ($process->type !== 'worker') {
            return null;
        }

        $keys = ['connection', 'queue', 'tries', 'backoff', 'sleep', 'rest', 'timeout', 'force'];
        $config = [];

        foreach ($keys as $key) {
            $value = $this->form()->get('config.'.$key);

            if ($value === null) {
                continue;
            }

            if ($key === 'force') {
                $config[$key] = (bool) $value;
            } elseif (in_array($key, ['tries', 'backoff', 'sleep', 'rest', 'timeout'], true)) {
                $config[$key] = (int) $value;
            } else {
                $config[$key] = (string) $value;
            }
        }

        return $config ?: null;
    }

    protected function shouldRunUpdateFromOptions(): bool
    {
        if ($this->option('force')) {
            return true;
        }

        return confirm('Update the background process?');
    }

    protected function defineFields(BackgroundProcess $process): void
    {
        $this->form()->define(
            'processes',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => (int) number(
                    label: 'Processes',
                    required: true,
                    default: (string) ($value ?? $process->processes),
                    min: 1,
                    max: 10,
                ),
            ),
        )->setPreviousValue((string) $process->processes);

        if ($process->type === 'custom') {
            $this->form()->define(
                'command',
                fn ($resolver) => $resolver->fromInput(
                    fn ($value) => text(
                        label: 'Command',
                        required: true,
                        default: $value ?? $process->command,
                    ),
                ),
            )->setPreviousValue($process->command);
        }

        if ($process->type === 'worker') {
            $this->defineWorkerConfigFields($process);
        }
    }

    protected function defineWorkerConfigFields(BackgroundProcess $process): void
    {
        $defaults = [
            'connection' => $process->connection ?? 'redis',
            'queue' => $process->queue ?? 'default',
            'tries' => (string) ($process->tries ?? 1),
            'backoff' => (string) ($process->backoff ?? 30),
            'sleep' => (string) ($process->sleep ?? 3),
            'rest' => (string) ($process->rest ?? 0),
            'timeout' => (string) ($process->timeout ?? 60),
            'force' => $process->force ?? false,
        ];

        $this->form()->define(
            'config.connection',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => text(
                    label: 'Connection',
                    required: true,
                    default: $value ?? $defaults['connection'],
                ),
            )->setLabel('Connection'),
            'connection',
        )->setPreviousValue($defaults['connection']);

        $this->form()->define(
            'config.queue',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => text(
                    label: 'Queue',
                    required: true,
                    default: $value ?? $defaults['queue'],
                    hint: 'Comma-separated for multiple queues',
                ),
            )->setLabel('Queue'),
            'queue',
        )->setPreviousValue($defaults['queue']);

        $this->form()->define(
            'config.tries',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => (int) number(
                    label: 'Tries',
                    required: true,
                    default: $value ?? $defaults['tries'],
                    hint: 'Number of times a job should be attempted',
                ),
            )->setLabel('Tries'),
            'tries',
        )->setPreviousValue($defaults['tries']);

        $this->form()->define(
            'config.backoff',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => (int) number(
                    label: 'Backoff',
                    required: true,
                    default: $value ?? $defaults['backoff'],
                    hint: 'Seconds before retrying a failed job',
                ),
            )->setLabel('Backoff'),
            'backoff',
        )->setPreviousValue($defaults['backoff']);

        $this->form()->define(
            'config.sleep',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => (int) number(
                    label: 'Sleep',
                    required: true,
                    default: $value ?? $defaults['sleep'],
                    hint: 'Seconds to sleep when no jobs available',
                ),
            )->setLabel('Sleep'),
            'sleep',
        )->setPreviousValue($defaults['sleep']);

        $this->form()->define(
            'config.rest',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => (int) number(
                    label: 'Rest',
                    required: true,
                    default: $value ?? $defaults['rest'],
                    hint: 'Seconds to rest between jobs',
                ),
            )->setLabel('Rest'),
            'rest',
        )->setPreviousValue($defaults['rest']);

        $this->form()->define(
            'config.timeout',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => (int) number(
                    label: 'Timeout',
                    required: true,
                    default: $value ?? $defaults['timeout'],
                    hint: 'Seconds a job can run before timing out',
                ),
            )->setLabel('Timeout'),
            'timeout',
        )->setPreviousValue($defaults['timeout']);

        $this->form()->define(
            'config.force',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => confirm(
                    label: 'Run in maintenance mode?',
                    default: (bool) ($value ?? $defaults['force']),
                    hint: 'Force the worker to run even in maintenance mode',
                ),
            )->setLabel('Run in maintenance mode'),
            'run-in-maintenance',
        )->setPreviousValue($defaults['force'] ? 'Yes' : 'No');
    }

    protected function collectDataAndUpdate(BackgroundProcess $process): BackgroundProcess
    {
        $options = collect($this->form()->defined())->mapWithKeys(fn ($field, $key) => [
            $field->key => $field->label(),
        ])->toArray();

        if (empty($options)) {
            $this->outputErrorOrThrow('No fields to update. Select at least one option.');

            throw new CommandExitException(self::FAILURE);
        }

        $selection = multiselect(
            label: 'What do you want to update?',
            options: $options,
        );

        if (empty($selection)) {
            $this->outputErrorOrThrow('No fields to update. Select at least one option.');

            throw new CommandExitException(self::FAILURE);
        }

        foreach ($selection as $optionName) {
            $this->form()->prompt($optionName);
        }

        return $this->updateProcess($process);
    }
}
