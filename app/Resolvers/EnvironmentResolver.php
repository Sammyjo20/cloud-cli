<?php

namespace App\Resolvers;

use App\Dto\Application;
use App\Dto\Environment;

use function Laravel\Prompts\select;

class EnvironmentResolver extends Resolver
{
    protected ?Application $application;

    public function withApplication(null|string|Application $application): self
    {
        if (is_string($application)) {
            $application = $this->resolvers()->application()->from($application);
        }

        $this->application = $application;

        return $this;
    }

    public function from(?string $idOrName = null): ?Environment
    {
        $this->application ??= $this->resolvers()->application()->resolve();

        $identifier = $idOrName ?? $this->localConfig->environmentId();

        $environment = ($identifier ? $this->fromIdentifier($identifier) : null) ?? $this->fromInput();

        if (! $environment) {
            $this->failAndExit('Unable to resolve environment: '.($idOrName ?? 'Provide a valid environment ID or name as an argument.'));
        }

        return $environment;
    }

    public function fromIdentifier(string $identifier): ?Environment
    {
        $envs = collect($this->application->environments);

        return $envs->firstWhere('id', $identifier) ?? $envs->firstWhere('name', $identifier);
    }

    public function fromInput(): ?Environment
    {
        $envs = collect($this->application->environments);

        if ($envs->hasSole()) {
            $this->displayResolved('Environment', $envs->first()->name);

            return $envs->first();
        }

        $this->ensureInteractive('Please provide an environment ID or name.');

        $selectedEnv = select(
            label: 'Environment',
            options: $envs->mapWithKeys(fn ($env) => [$env->id => $env->name]),
        );

        return $envs->firstWhere('id', $selectedEnv);
    }
}
