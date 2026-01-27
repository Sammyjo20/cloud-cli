<?php

namespace App\Client\Resources\Environments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListEnvironmentLogsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $environmentId,
        protected string $from,
        protected string $to,
        protected ?string $cursor = null,
        protected ?string $type = null,
        protected ?string $query = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/environments/{$this->environmentId}/logs";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'from' => $this->from,
            'to' => $this->to,
            'cursor' => $this->cursor,
            'type' => $this->type,
            'query' => $this->query,
        ]);
    }
}
