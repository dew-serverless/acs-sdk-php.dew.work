<?php

namespace App\Metadata;

use Illuminate\Support\Arr;
use InvalidArgumentException;

readonly class ApiDocs
{
    /**
     * @param  array<string, mixed>  $definition
     */
    public function __construct(
        private array $definition
    ) {
        //
    }

    public function getApi(string $name): Api
    {
        if (! isset($this->apis[$name])) {
            throw new InvalidArgumentException("Could not find $name API.");
        }

        $instance = match ($this->info['style'] ?? null) {
            'RPC' => new RpcApi($name, $this->apis[$name]),
            default => new RoaApi($name, $this->apis[$name]),
        };

        return $instance->setSchemaFinder(new SchemaFinder($this->definition));
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->definition, $property);
    }
}
