<?php

namespace App\Commands;

use App\Enums\InstanceSize;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\number;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class InstanceCreate extends BaseCommand
{
    protected $signature = 'instance:create
                            {environment? : The environment ID}
                            {--name= : Instance name}
                            {--type=service : Instance type (app|worker)}
                            {--size= : Instance size}
                            {--min-replicas= : Minimum replicas}
                            {--max-replicas= : Maximum replicas}
                            {--json : Output as JSON}';

    protected $description = 'Create a new instance';

    public function handle()
    {
        $this->ensureClient();

        $email = text(
            label: 'What is your email address',
            placeholder: 'E.g. taylor@laravel.com',
            // validate: fn ($value) => match (true) {
            //     strlen($value) === 0 => 'Please enter an email address.',
            //     ! filter_var($value, FILTER_VALIDATE_EMAIL) => 'Please enter a valid email address.',
            //     default => null,
            // },
            validate: 'required|int|min:0',
            hint: 'We will never share your email address with anyone else.',
            transform: fn ($value) => strtolower($value),
        );

        intro('Create Instance');

        $environment = $this->resolvers()->environment()->from($this->argument('environment'));

        $instance = $this->loopUntilValid(fn () => $this->createInstance($environment->id));

        $this->outputJsonIfWanted($instance);

        outro("Instance created: {$instance->name}");
    }

    protected function createInstance(string $environmentId)
    {
        $this->addParam(
            'name',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => text(
                    label: 'Name',
                    default: $value ?? '',
                    required: true,
                ),
            ),
        );

        $this->addParam(
            'size',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => search(
                    label: 'Size',
                    options: fn ($query) => collect(InstanceSize::cases())
                        ->map(fn ($size) => $size->value)
                        ->filter(fn ($size) => $query === '' ? true : str_contains($size, $query))
                        ->toArray(),
                    required: true,
                ),
            ),
        );

        $this->addParam(
            'scaling_type',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => select(
                    label: 'Scaling type',
                    options: [
                        'none' => 'None',
                        'custom' => 'Custom',
                        'auto' => 'Auto',
                    ],
                    default: $value ?? 'none',
                    required: true,
                ),
            ),
        );

        $isCustom = $this->getParam('scaling_type') === 'custom';

        $this->addParam(
            'min_replicas',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => $isCustom ? number(
                    label: 'Minimum replicas',
                    default: $value ?? '1',
                    min: 1,
                    max: 10,
                ) : 1,
            ),
        );

        $this->addParam(
            'max_replicas',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => $isCustom ? number(
                    label: 'Maximum replicas',
                    default: $value ?? $this->getParam('min-replicas'),
                    min: $this->getParam('min-replicas'),
                    max: 10,
                ) : $this->getParam('min-replicas'),
            ),
        );

        if ($isCustom) {
            $this->addParam(
                'scaling_cpu_threshold_percentage',
                fn ($resolver) => $resolver->fromInput(fn ($value) => number(
                    label: 'Scaling CPU threshold percentage',
                    default: $value ?? '50',
                    min: 50,
                    max: 95,
                )),
            );

            $this->addParam(
                'scaling_memory_threshold_percentage',
                fn ($resolver) => $resolver->fromInput(fn ($value) => number(
                    label: 'Scaling memory threshold percentage',
                    default: $value ?? '50',
                )),
            );
        }

        $this->addParam(
            'type',
            fn ($resolver) => $resolver->fromInput(fn () => 'service'),
        );

        $this->addParam(
            'uses_scheduler',
            fn ($resolver) => $resolver->fromInput(
                fn ($value) => confirm(
                    label: 'Use scheduler?',
                    default: false,
                ),
            ),
        );

        return spin(
            fn () => $this->client->instances()->create(
                $environmentId,
                $this->getParams(),
            ),
            'Creating instance...',
        );
    }
}
