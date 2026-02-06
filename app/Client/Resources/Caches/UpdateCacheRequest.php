<?php

namespace App\Client\Resources\Caches;

use App\Client\Requests\UpdateCacheRequestData;
use App\Dto\Cache;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateCacheRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected UpdateCacheRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/caches/{$this->data->cacheId}";
    }

    protected function defaultBody(): array
    {
        return $this->data->toRequestData();
    }

    public function createDtoFromResponse(Response $response): Cache
    {
        return Cache::createFromResponse($response->json());
    }
}
