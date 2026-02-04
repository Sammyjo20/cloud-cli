<?php

namespace App\Client\Resources;

use App\Client\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Paginator;

abstract class Resource
{
    protected array $includes = [];

    public function __construct(
        protected Connector $connector,
    ) {
        //
    }

    public function include(string ...$includes): static
    {
        $this->includes = $includes;

        return $this;
    }

    protected function send(Request $request): Response
    {
        $this->withIncludes($request);

        return $this->connector->send($request);
    }

    protected function paginate(Request $request): Paginator
    {
        $this->withIncludes($request);

        return $this->connector->paginate($request);
    }

    protected function getIncludesString(): ?string
    {
        if (empty($this->includes)) {
            return null;
        }

        return implode(',', $this->includes);
    }

    protected function withIncludes(Request $request): Request
    {
        if (empty($this->includes)) {
            $this->withDefaultIncludes();
        }

        if (method_exists($request, 'include')) {
            $request->include($this->getIncludesString());
        }

        return $request;
    }

    public function withDefaultIncludes(): static
    {
        return $this;
    }
}
