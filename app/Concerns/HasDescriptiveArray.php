<?php

namespace App\Concerns;

trait HasDescriptiveArray
{
    public function descriptiveArray(): array
    {
        return collect($this->toArray())
            ->mapWithKeys(fn ($value, $key) => [
                $this->descriptiveKey($key) => $value,
            ])
            ->toArray();
    }

    protected function descriptiveKey(string $key): string
    {
        if ($key === 'id') {
            return 'ID';
        }

        return str($key)->replaceMatches('/[A-Z]/', ' $0')->title()->toString();
    }
}
