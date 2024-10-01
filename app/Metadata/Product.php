<?php

namespace App\Metadata;

use Illuminate\Support\Arr;

readonly class Product
{
    public function __construct(
        private array $info
    ) {
        //
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->info, $property);
    }
}
