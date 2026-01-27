<?php

namespace App\Client\Resources\Applications;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateApplicationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $repository,
        protected string $name,
        protected string $region,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return '/applications';
    }

    protected function defaultBody(): array
    {
        return [
            'repository' => $this->repository,
            'name' => $this->name,
            'region' => $this->region,
        ];
    }
}
