<?php

namespace App\Metadata;

use Illuminate\Support\Arr;

class Parameter
{
    /**
     * @param  array<string, mixed>  $definition
     */
    public function __construct(
        private array $definition,
        private SchemaReader $schemaReader
    ) {
        //
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getSchema(): ?array
    {
        if (! isset($this->definition['schema'])) {
            return null;
        }

        $schema = $this->definition['schema'];

        return $this->schemaReader->read($schema);
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->definition, $property);
    }
}
