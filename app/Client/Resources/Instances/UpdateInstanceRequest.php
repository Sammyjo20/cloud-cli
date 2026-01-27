<?php

namespace App\Client\Resources\Instances;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateInstanceRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $instanceId,
        protected array $data,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/instances/{$this->instanceId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
