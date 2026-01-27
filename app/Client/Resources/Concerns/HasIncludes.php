<?php

namespace App\Client\Resources\Concerns;

trait HasIncludes
{
    protected ?array $includes = null;

    public function include(string ...$includes): static
    {
        $this->includes = $includes;

        return $this;
    }

    protected function getIncludesString(): ?string
    {
        if ($this->includes === null) {
            return null;
        }

        return implode(',', $this->includes);
    }
}
