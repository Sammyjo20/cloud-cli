<?php

namespace App\Client\Resources\CliAuth;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateAuthSessionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected int $port,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/cli/auth-sessions';
    }

    protected function defaultBody(): array
    {
        return [
            'port' => $this->port,
        ];
    }

    public function hasAuthenticator(): bool
    {
        return false;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->json();
    }
}
