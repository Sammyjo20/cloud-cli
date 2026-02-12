<?php

namespace App\Dto;

use Spatie\LaravelData\Data;

class InstanceSizes extends Data
{
    /**
     * @param  array<string, list<InstanceSizeOption>>  $categories
     */
    public function __construct(
        public readonly array $categories,
    ) {
        //
    }

    public static function createFromResponse(array $response): self
    {
        $data = $response['data'] ?? [];
        $categories = [];

        foreach ($data as $category => $items) {
            $categories[$category] = array_map(
                InstanceSizeOption::fromApiResponse(...),
                $items,
            );
        }

        return self::from(['categories' => $categories]);
    }

    /**
     * @return list<InstanceSizeOption>
     */
    public function all(): array
    {
        return array_merge(...array_values($this->categories));
    }
}
