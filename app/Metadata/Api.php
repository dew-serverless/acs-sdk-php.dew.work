<?php

namespace App\Metadata;

use Illuminate\Support\Arr;

readonly class Api
{
    /**
     * @param  array<string, mixed>  $definition
     */
    public function __construct(
        private string $name,
        private array $definition
    ) {
        //
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->definition, $property);
    }
}
