<?php

namespace App\Dto;

class ValidationErrors
{
    protected array $errors = [];

    public function add(string $field): void
    {
        $this->errors[$field] = true;
    }

    public function has(string $field): bool
    {
        return isset($this->errors[$field]);
    }

    public function clear(): void
    {
        $this->errors = [];
    }
}
