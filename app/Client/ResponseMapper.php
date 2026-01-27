<?php

namespace App\Client;

use App\Dto\Application;
use App\Dto\BackgroundProcess;
use App\Dto\Command;
use App\Dto\Database;
use App\Dto\DatabaseCluster;
use App\Dto\Deployment;
use App\Dto\Domain;
use App\Dto\Environment;
use App\Dto\EnvironmentInstance;
use App\Dto\Organization;
use App\Dto\Paginated;
use App\Dto\Region;
use Carbon\CarbonImmutable;

class ResponseMapper
{
    public static function mapApplication(array $response, ?array $item = null): Application
    {
        $data = $item ?? $response['data'];
        $included = $response['included'] ?? [];

        $attributes = $data['attributes'];
        $repository = $attributes['repository'] ?? null;
        $relationships = $data['relationships'] ?? [];

        $organizationId = $relationships['organization']['data']['id'] ?? null;
        $environmentIds = array_column($relationships['environments']['data'] ?? [], 'id');
        $deploymentIds = array_column($relationships['deployments']['data'] ?? [], 'id');

        $organization = null;
        if ($organizationId) {
            $orgData = collect($included)->first(fn ($item) => $item['type'] === 'organizations' && $item['id'] === $organizationId);
            if ($orgData) {
                $organization = self::mapOrganization(['data' => $orgData], $orgData);
            }
        }

        $environments = collect($included)
            ->filter(fn ($item) => $item['type'] === 'environments' && in_array($item['id'], $environmentIds))
            ->map(fn ($item) => self::mapEnvironment(['data' => $item, 'included' => $included], $item))
            ->values()
            ->toArray();

        $deployments = collect($included)
            ->filter(fn ($item) => $item['type'] === 'deployments' && in_array($item['id'], $deploymentIds))
            ->map(fn ($item) => self::mapDeployment(['data' => $item, 'included' => $included], $item))
            ->values()
            ->toArray();

        return new Application(
            id: $data['id'],
            name: $attributes['name'],
            slug: $attributes['slug'],
            region: $attributes['region'],
            repositoryFullName: $repository ? ($repository['full_name'] ?? null) : null,
            repositoryBranch: $repository ? ($repository['default_branch'] ?? null) : null,
            slackChannel: $attributes['slack_channel'] ?? null,
            createdAt: $attributes['created_at'] ? CarbonImmutable::parse($attributes['created_at']) : null,
            repositoryId: $relationships['repository']['data']['id'] ?? null,
            organizationId: $organizationId,
            environmentIds: $environmentIds,
            deploymentIds: $deploymentIds,
            defaultEnvironmentId: $relationships['defaultEnvironment']['data']['id'] ?? null,
            organization: $organization,
            environments: $environments,
            deployments: $deployments,
        );
    }

    public static function mapEnvironment(array $response, ?array $item = null): Environment
    {
        $data = $item ?? $response['data'] ?? [];
        $included = $response['included'] ?? [];

        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];

        $vanityDomain = $attributes['vanity_domain'] ?? '';
        $buildCommand = $attributes['build_command'] ?? null;
        $deployCommand = $attributes['deploy_command'] ?? null;

        return new Environment(
            id: $data['id'],
            name: $attributes['name'],
            url: $vanityDomain ? str($vanityDomain)->start('https://') : '',
            branch: $attributes['branch'] ?? null,
            status: $attributes['status'] ?? null,
            instances: array_column($relationships['instances']['data'] ?? [], 'id'),
            buildCommand: $buildCommand,
            deployCommand: $deployCommand,
            slug: $attributes['slug'] ?? '',
            statusEnum: isset($attributes['status']) ? \App\Enums\EnvironmentStatus::from($attributes['status']) : \App\Enums\EnvironmentStatus::STOPPED,
            createdFromAutomation: $attributes['created_from_automation'] ?? false,
            vanityDomain: $vanityDomain,
            phpMajorVersion: $attributes['php_major_version'] ?? '',
            nodeVersion: $attributes['node_version'] ?? null,
            usesOctane: $attributes['uses_octane'] ?? false,
            usesHibernation: $attributes['uses_hibernation'] ?? false,
            usesPushToDeploy: $attributes['uses_push_to_deploy'] ?? false,
            usesDeployHook: $attributes['uses_deploy_hook'] ?? false,
            environmentVariables: $attributes['environment_variables'] ?? [],
            networkSettings: $attributes['network_settings'] ?? [],
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            applicationId: $relationships['application']['data']['id'] ?? null,
            branchId: $relationships['branch']['data']['id'] ?? null,
            deploymentIds: array_column($relationships['deployments']['data'] ?? [], 'id'),
            currentDeploymentId: $relationships['currentDeployment']['data']['id'] ?? null,
            domainIds: array_column($relationships['domains']['data'] ?? [], 'id'),
            primaryDomainId: $relationships['primaryDomain']['data']['id'] ?? null,
        );
    }

    public static function mapDeployment(array $response, ?array $item = null): Deployment
    {
        $data = $item ?? $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];
        $commit = $attributes['commit'] ?? [];

        return new Deployment(
            id: $data['id'],
            status: \App\Enums\DeploymentStatus::from($attributes['status'] ?? 'pending'),
            commitHash: $commit['hash'] ?? $attributes['commit_hash'] ?? null,
            commitMessage: $commit['message'] ?? $attributes['commit_message'] ?? null,
            commitAuthor: $commit['author'] ?? $attributes['commit_author'] ?? null,
            startedAt: isset($attributes['started_at']) ? CarbonImmutable::parse($attributes['started_at']) : null,
            finishedAt: isset($attributes['finished_at']) ? CarbonImmutable::parse($attributes['finished_at']) : null,
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            failureReason: $attributes['failure_reason'] ?? null,
            branchName: $attributes['branch_name'] ?? '',
            phpMajorVersion: $attributes['php_major_version'] ?? '',
            buildCommand: $attributes['build_command'] ?? null,
            nodeVersion: $attributes['node_version'] ?? null,
            usesOctane: $attributes['uses_octane'] ?? false,
            usesHibernation: $attributes['uses_hibernation'] ?? false,
            environmentId: $relationships['environment']['data']['id'] ?? null,
            initiatorId: $relationships['initiator']['data']['id'] ?? null,
        );
    }

    public static function mapDomain(array $response, ?array $item = null): Domain
    {
        $data = $item ?? $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];

        return new Domain(
            id: $data['id'],
            domain: $attributes['domain'] ?? '',
            status: $attributes['status'] ?? '',
            isPrimary: $attributes['is_primary'] ?? false,
            verificationStatus: $attributes['verification_status'] ?? null,
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            environmentId: $relationships['environment']['data']['id'] ?? null,
        );
    }

    public static function mapEnvironmentInstance(array $response, ?array $item = null): EnvironmentInstance
    {
        $data = $item ?? $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];

        return new EnvironmentInstance(
            id: $data['id'],
            name: $attributes['name'],
            type: $attributes['type'],
            size: $attributes['size'],
            scalingType: $attributes['scaling_type'],
            minReplicas: $attributes['min_replicas'],
            maxReplicas: $attributes['max_replicas'],
            usesScheduler: $attributes['uses_scheduler'],
            scalingCpuThresholdPercentage: $attributes['scaling_cpu_threshold_percentage'] ?? null,
            scalingMemoryThresholdPercentage: $attributes['scaling_memory_threshold_percentage'] ?? null,
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            environmentId: $relationships['environment']['data']['id'] ?? null,
            backgroundProcessIds: array_column($relationships['backgroundProcesses']['data'] ?? [], 'id'),
        );
    }

    public static function mapCommand(array $response, ?array $item = null): Command
    {
        $data = $item ?? $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];

        return new Command(
            id: $data['id'],
            command: $attributes['command'] ?? '',
            status: $attributes['status'] ?? '',
            output: $attributes['output'] ?? null,
            exitCode: $attributes['exit_code'] ?? null,
            startedAt: isset($attributes['started_at']) ? CarbonImmutable::parse($attributes['started_at']) : null,
            finishedAt: isset($attributes['finished_at']) ? CarbonImmutable::parse($attributes['finished_at']) : null,
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            environmentId: $relationships['environment']['data']['id'] ?? null,
            instanceId: $relationships['instance']['data']['id'] ?? null,
        );
    }

    public static function mapBackgroundProcess(array $response, ?array $item = null): BackgroundProcess
    {
        $data = $item ?? $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];
        $relationships = $data['relationships'] ?? [];

        return new BackgroundProcess(
            id: $data['id'],
            command: $attributes['command'] ?? '',
            instances: $attributes['instances'] ?? 1,
            type: $attributes['type'] ?? '',
            queue: $attributes['queue'] ?? null,
            connection: $attributes['connection'] ?? null,
            timeout: $attributes['timeout'] ?? null,
            sleep: $attributes['sleep'] ?? null,
            tries: $attributes['tries'] ?? null,
            maxProcesses: $attributes['max_processes'] ?? null,
            minProcesses: $attributes['min_processes'] ?? null,
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            instanceId: $relationships['instance']['data']['id'] ?? null,
        );
    }

    public static function mapDatabaseCluster(array $response, ?array $item = null): DatabaseCluster
    {
        $data = $item ?? $response['data'] ?? [];
        $included = $response['included'] ?? [];
        $attributes = $data['attributes'] ?? [];

        return new DatabaseCluster(
            id: $data['id'],
            name: $attributes['name'],
            type: $attributes['type'],
            status: $attributes['status'],
            region: $attributes['region'],
            config: $attributes['config'] ?? [],
            connection: $attributes['connection'] ?? [],
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
            updatedAt: isset($attributes['updated_at']) ? CarbonImmutable::parse($attributes['updated_at']) : null,
            schemas: collect($included)
                ->filter(fn ($item) => $item['type'] === 'databaseSchemas')
                ->map(fn ($item) => self::mapDatabase(['data' => $item], $item))
                ->values()
                ->toArray(),
        );
    }

    public static function mapDatabase(array $response, ?array $item = null): Database
    {
        $data = $item ?? $response['data'] ?? [];
        $attributes = $data['attributes'] ?? [];

        return new Database(
            id: $data['id'],
            name: $attributes['name'],
            createdAt: isset($attributes['created_at']) ? CarbonImmutable::parse($attributes['created_at']) : null,
        );
    }

    public static function mapOrganization(array $response, ?array $item = null): Organization
    {
        $data = $item ?? $response['data'];
        $attributes = $data['attributes'];

        return new Organization(
            id: $data['id'],
            name: $attributes['name'],
            slug: $attributes['slug'],
        );
    }

    public static function mapRegion(array $response, ?array $item = null): Region
    {
        $data = $item ?? $response['data'] ?? [];

        return new Region(
            value: $data['region'],
            label: $data['label'],
            flag: $data['flag'],
        );
    }

    public static function mapPaginated(array $response, callable $mapper): Paginated
    {
        $data = $response['data'] ?? [];
        $links = $response['links'] ?? [];

        $mappedData = collect($data)->map(fn ($item) => $mapper($response, $item))->toArray();

        return new Paginated(
            data: $mappedData,
            links: $links,
        );
    }
}
