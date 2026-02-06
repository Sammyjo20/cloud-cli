<?php

namespace App\Client\Resources\Caches;

use App\Client\Requests\CreateCacheRequestData;
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
        protected CreateCacheRequestData $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/caches';
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
