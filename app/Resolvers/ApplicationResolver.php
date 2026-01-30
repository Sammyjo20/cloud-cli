<?php

namespace App\Resolvers;

use App\Dto\Application;
use App\Git;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use RuntimeException;
use Throwable;

use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;

class ApplicationResolver extends Resolver
{
    public function resolve(): ?Application
    {
        return $this->from();
    }

    public function from(?string $idOrName = null): ?Application
    {
        $identifier = $idOrName ?? $this->localConfig->applicationId();

        $app = ($identifier ? $this->fromIdentifier($identifier) : null)
            ?? $this->fromRepo()
            ?? $this->fromInput();

        if (! $app) {
            $this->failAndExit('Unable to resolve application: '.($idOrName ?? 'Provide a valid application ID or name as an argument.'));
        }

        return $app;
    }

    public function fromIdentifier(string $identifier): ?Application
    {
        if (str_starts_with($identifier, 'app-')) {
            try {
                return spin(
                    fn () => $this->client->applications()->withDefaultIncludes()->get($identifier),
                    'Fetching application...',
                );
            } catch (Throwable $e) {
                return $this->fetchAndFind($identifier);
            }
        }

        $app = $this->fetchAndFind($identifier);

        if (! $app) {
            throw new RuntimeException("Application '{$identifier}' not found.");
        }

        $this->displayResolved('Application', $app->name);

        return $app;
    }

    public function fromRepo(): ?Application
    {
        $repository = app(Git::class)->remoteRepo();
        $apps = $this->fetchAll();

        return $apps->firstWhere('repositoryFullName', $repository);
    }

    public function fromInput(): ?Application
    {
        $apps = $this->fetchAll();

        if ($apps->hasSole()) {
            $app = $apps->first();

            $this->displayResolved('Application', $app->name);

            return $app;
        }

        $this->ensureInteractive('Please provide an application ID or name.');

        $selectedApp = select(
            label: 'Application',
            options: $apps->mapWithKeys(fn ($app) => [$app->id => $app->name]),
        );

        return $apps->fromCollection($apps, $selectedApp);
    }

    public function fromCollection(Collection|LazyCollection $apps, string $identifier): ?Application
    {
        return $apps->firstWhere('id', $identifier) ?? $apps->firstWhere('name', $identifier);
    }

    public function fetchAndFind(string $identifier): ?Application
    {
        return $this->fromCollection($this->fetchAll(), $identifier);
    }

    protected function fetchAll(): Collection|LazyCollection
    {
        return collect(spin(
            fn () => $this->client->applications()->withDefaultIncludes()->list()->items(),
            'Fetching applications...',
        ));
    }
}
