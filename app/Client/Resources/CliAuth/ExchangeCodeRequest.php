<?php

namespace App\Client\Resources\CliAuth;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ExchangeCodeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $exchangeCode,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/cli/auth-sessions/exchange';
    }

    protected function defaultBody(): array
    {
        return [
            'exchange_code' => $this->exchangeCode,
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
