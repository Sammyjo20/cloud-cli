<?php

namespace App\Client\Resources\Instances;

use App\Client\Resources\Concerns\AcceptsInclude;
use App\Dto\InstanceSizes;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListInstanceSizesRequest extends Request
{
    use AcceptsInclude;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/instances/sizes';
    }

    public function createDtoFromResponse(Response $response): InstanceSizes
    {
        return InstanceSizes::createFromResponse($response->json());
    }
}
