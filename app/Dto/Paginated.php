<?php

namespace App\Dto;

/**
 * @template TData
 *
 * @property-read TData[] $data
 */
class Paginated
{
    public function __construct(
        public readonly array $data,
        public readonly array $links,
    ) {
        //
    }
}
