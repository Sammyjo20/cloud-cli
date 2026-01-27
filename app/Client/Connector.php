<?php

namespace App\Client;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector as SaloonConnector;
use SensitiveParameter;

class Connector extends SaloonConnector
{
    public function __construct(
        #[SensitiveParameter]
        protected string $apiToken,
    ) {
        //
    }

    public function resolveBaseUrl(): string
    {
        return 'https://cloud.laravel.com/api';
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiToken);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];
    }

    public function applications(): ApplicationsResource
    {
        return new ApplicationsResource($this);
    }

    public function environments(): EnvironmentsResource
    {
        return new EnvironmentsResource($this);
    }

    public function deployments(): DeploymentsResource
    {
        return new DeploymentsResource($this);
    }

    public function domains(): DomainsResource
    {
        return new DomainsResource($this);
    }

    public function instances(): InstancesResource
    {
        return new InstancesResource($this);
    }

    public function commands(): CommandsResource
    {
        return new CommandsResource($this);
    }

    public function backgroundProcesses(): BackgroundProcessesResource
    {
        return new BackgroundProcessesResource($this);
    }

    public function databaseClusters(): DatabaseClustersResource
    {
        return new DatabaseClustersResource($this);
    }

    public function databases(): DatabasesResource
    {
        return new DatabasesResource($this);
    }

    public function databaseSnapshots(): DatabaseSnapshotsResource
    {
        return new DatabaseSnapshotsResource($this);
    }

    public function databaseRestores(): DatabaseRestoresResource
    {
        return new DatabaseRestoresResource($this);
    }

    public function objectStorageBuckets(): ObjectStorageBucketsResource
    {
        return new ObjectStorageBucketsResource($this);
    }

    public function bucketKeys(): BucketKeysResource
    {
        return new BucketKeysResource($this);
    }

    public function caches(): CachesResource
    {
        return new CachesResource($this);
    }

    public function websocketClusters(): WebSocketClustersResource
    {
        return new WebSocketClustersResource($this);
    }

    public function websocketApplications(): WebSocketApplicationsResource
    {
        return new WebSocketApplicationsResource($this);
    }

    public function meta(): MetaResource
    {
        return new MetaResource($this);
    }

    public function dedicatedClusters(): DedicatedClustersResource
    {
        return new DedicatedClustersResource($this);
    }
}
