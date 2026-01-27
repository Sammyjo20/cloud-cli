<?php

namespace App\Client\Resources\Caches;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateCacheRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $type,
        protected string $name,
        protected string $region,
        protected array $config,
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
            'config' => $this->config,
        ];
    }
}
