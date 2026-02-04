<?php

use App\Client\Resources\Applications\ListApplicationsRequest;
use App\Client\Resources\Meta\GetOrganizationRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function createApplicationResponse(array $overrides = []): array
{
    $base = [
        'id' => 'app-123',
        'type' => 'applications',
        'attributes' => [
            'name' => 'My App',
            'slug' => 'my-app',
            'region' => 'us-east-1',
            'repository' => [
                'full_name' => 'user/my-app',
                'default_branch' => 'main',
            ],
        ],
        'relationships' => [
            'organization' => ['data' => ['id' => 'org-1', 'type' => 'organizations']],
            'environments' => ['data' => [['id' => 'env-1', 'type' => 'environments']]],
            'defaultEnvironment' => ['data' => ['id' => 'env-1', 'type' => 'environments']],
        ],
    ];

    if (isset($overrides['id'])) {
        $base['id'] = $overrides['id'];
    }

    if (isset($overrides['attributes'])) {
        $base['attributes'] = array_merge($base['attributes'], $overrides['attributes']);
    }

    if (isset($overrides['relationships'])) {
        $base['relationships'] = array_merge($base['relationships'], $overrides['relationships']);
    }

    return $base;
}

function createEnvironmentResponse(array $overrides = []): array
{
    $base = [
        'id' => 'env-1',
        'type' => 'environments',
        'attributes' => [
            'name' => 'production',
            'slug' => 'production',
            'vanity_domain' => 'my-app.cloud.laravel.com',
            'status' => 'running',
            'php_major_version' => '8.3',
        ],
    ];

    if (isset($overrides['id'])) {
        $base['id'] = $overrides['id'];
    }

    if (isset($overrides['attributes'])) {
        $base['attributes'] = array_merge($base['attributes'], $overrides['attributes']);
    }

    return $base;
}

function organizationResponse(): array
{
    return [
        'data' => [
            'id' => 'org-1',
            'type' => 'organizations',
            'attributes' => ['name' => 'My Org', 'slug' => 'my-org'],
        ],
    ];
}

function regionsResponse(): array
{
    return [
        'data' => [
            ['region' => 'us-east-1', 'label' => 'US East', 'flag' => 'us'],
        ],
    ];
}

function setupApplicationListMocks(?array $applications = null, int $status = 200): void
{
    $applications = $applications ?? [createApplicationResponse()];

    MockClient::global([
        GetOrganizationRequest::class => MockResponse::make(organizationResponse(), 200),
        ListApplicationsRequest::class => MockResponse::make([
            'data' => $applications,
            'included' => [
                ['id' => 'org-1', 'type' => 'organizations', 'attributes' => ['name' => 'My Org', 'slug' => 'my-org']],
                ['id' => 'env-1', 'type' => 'environments', 'attributes' => ['name' => 'production', 'slug' => 'production', 'vanity_domain' => 'my-app.cloud.laravel.com', 'status' => 'running', 'php_major_version' => '8.3']],
            ],
            'links' => ['next' => null],
        ], $status),
    ]);
}
