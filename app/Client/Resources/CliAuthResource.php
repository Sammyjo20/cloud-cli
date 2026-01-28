<?php

namespace App\Client\Resources;

use App\Client\Connector;
use App\Client\Resources\CliAuth\CreateAuthSessionRequest;
use App\Client\Resources\CliAuth\ExchangeCodeRequest;

class CliAuthResource
{
    public function __construct(
        protected Connector $connector,
    ) {
        //
    }

    public function createAuthSession(int $port): string
    {
        $request = new CreateAuthSessionRequest($port);

        $response = $this->connector->send($request);

        return $response->json()['redirect_url'];
    }

    /**
     * @return array<int, array{organization_name: string, token: string}>
     */
    public function exchangeCode(string $exchangeCode): array
    {
        $request = new ExchangeCodeRequest($exchangeCode);

        $response = $this->connector->send($request);

        return $response->json()['tokens'];
    }
}
