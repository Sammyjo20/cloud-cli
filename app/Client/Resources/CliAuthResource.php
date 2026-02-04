<?php

namespace App\Client\Resources;

use App\Client\Resources\CliAuth\CreateAuthSessionRequest;
use App\Client\Resources\CliAuth\ExchangeCodeRequest;

class CliAuthResource extends Resource
{
    public function createAuthSession(int $port): string
    {
        $request = new CreateAuthSessionRequest($port);
        $response = $this->send($request);

        return $response->json()['redirect_url'];
    }

    /**
     * @return array<int, array{organization_name: string, token: string}>
     */
    public function exchangeCode(string $exchangeCode): array
    {
        $request = new ExchangeCodeRequest($exchangeCode);
        $response = $this->send($request);

        return $response->json()['tokens'];
    }
}
