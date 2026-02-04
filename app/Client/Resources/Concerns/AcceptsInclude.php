<?php

namespace App\Client\Resources\Concerns;

trait AcceptsInclude
{
    protected ?string $include = null;

    public function include(?string $include): static
    {
        $this->include = $include;

        return $this;
    }

    public function getInclude(): ?string
    {
        return $this->include;
    }

    /**
     * Query params for the include parameter. Merge with other params in defaultQuery() when needed.
     *
     * @return array<string, string|null>
     */
    protected function includeQuery(): array
    {
        return array_filter(['include' => $this->include]);
    }

    protected function defaultQuery(): array
    {
        return $this->includeQuery();
    }
}
