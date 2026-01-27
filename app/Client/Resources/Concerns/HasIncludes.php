<?php

namespace App\Client\Resources\Concerns;

trait HasIncludes
{
    protected ?array $includes = null;

    public function include(string|array ...$includes): static
    {
        $this->includes = is_array($includes[0]) ? $includes[0] : $includes;

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
