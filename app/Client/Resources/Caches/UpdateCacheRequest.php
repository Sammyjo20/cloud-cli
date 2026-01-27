<?php

namespace App\Client\Resources\Caches;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateCacheRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $cacheId,
        protected array $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/caches/{$this->cacheId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
