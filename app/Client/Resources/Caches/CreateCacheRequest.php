<?php

namespace App\Client\Resources\Caches;

use App\Dto\Cache;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateCacheRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $type,
        protected string $name,
        protected string $region,
        protected array $configData,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/caches';
    }

    protected function defaultBody(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'region' => $this->region,
            'config' => $this->configData,
        ];
    }

    public function createDtoFromResponse(Response $response): Cache
    {
        return Cache::createFromResponse($response->json());
    }
}
