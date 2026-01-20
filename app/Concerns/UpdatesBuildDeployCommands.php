<?php

namespace App\Concerns;

use App\Dto\Environment;

use function Laravel\Prompts\textarea;

trait UpdatesBuildDeployCommands
{
    use Validates;

    protected function updateCommands(Environment $environment): void
    {
        $this->loopUntilValid(
            function () use ($environment) {
                $buildCommand = textarea(
                    label: 'Build command',
                    default: $environment->buildCommand,
                    required: true,
                );

                if ($buildCommand === $environment->buildCommand) {
                    return;
                }

                return dynamicSpinner(
                    fn () => $this->client->updateEnvironment($environment->id, [
                        'build_command' => $buildCommand,
                    ]),
                    'Updating build command',
                );
            },
        );

        $this->loopUntilValid(
            function () use ($environment) {
                $deployCommand = textarea(
                    label: 'Deploy command',
                    default: $environment->deployCommand,
                    required: true,
                );

                if ($deployCommand === $environment->deployCommand) {
                    return;
                }

                return dynamicSpinner(
                    fn () => $this->client->updateEnvironment($environment->id, [
                        'deploy_command' => $deployCommand,
                    ]),
                    'Updating deploy command',
                );
            },
        );
    }
}
