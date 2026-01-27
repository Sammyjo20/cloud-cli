<?php

namespace App\Client\Resources\Environments;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class ReplaceEnvironmentVariablesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $environmentId,
        protected array $variables,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/variables";
    }

    protected function defaultBody(): array
    {
        return [
            'method' => 'replace',
            'variables' => collect($this->variables)->map(fn ($value, $key) => [
                'key' => $key,
                'value' => $value,
            ])->values()->toArray(),
        ];
    }
}
