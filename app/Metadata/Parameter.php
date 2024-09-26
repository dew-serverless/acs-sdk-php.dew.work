<?php

namespace App\Metadata;

use Illuminate\Support\Arr;

class Parameter
{
    private SchemaFinder $schemaFinder;

    /**
     * @param  array<string, mixed>  $definition
     */
    public function __construct(
        private array $definition
    ) {
        //
    }

    public function setSchemaFinder(SchemaFinder $finder): self
    {
        $this->schemaFinder = $finder;

        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getSchema(): ?array
    {
        $schema = $this->definition['schema'];

        return $this->decodeSchema($schema);
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private function decodeSchema(array $schema): array
    {
        if (isset($schema['$ref'])) {
            $ref = $this->schemaFinder->find($schema['$ref']);

            if ($ref === null) {
                return $schema;
            }

            return [
                ...$schema,
                ...$this->decodeSchema($ref),
            ];
        }

        return match ($schema['type']) {
            'object' => $this->decodeObjectSchema($schema),
            'array' => $this->decodeArraySchema($schema),
            default => $schema,
        };
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private function decodeObjectSchema(array $schema): array
    {
        return match (true) {
            isset($schema['properties']) => $this->decodeObjectPropertiesSchema($schema),
            isset($schema['additionalProperties']) => $this->decodeObjectAdditionalSchema($schema),
            default => $schema,
        };
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private function decodeObjectPropertiesSchema(array $schema): array
    {
        if (! isset($schema['properties'])) {
            return $schema;
        }

        foreach ($schema['properties'] as $property => $propSchema) {
            $schema['properties'][$property] = $this->decodeSchema($propSchema);
        }

        return $schema;
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private function decodeObjectAdditionalSchema(array $schema): array
    {
        if (! isset($schema['additionalProperties'])) {
            return $schema;
        }

        $schema['additionalProperties'] = $this->decodeSchema($schema['additionalProperties']);

        return $schema;
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private function decodeArraySchema(array $schema): array
    {
        if (! isset($schema['items'])) {
            return $schema;
        }

        $schema['items'] = $this->decodeSchema($schema['items']);

        return $schema;
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->definition, $property);
    }
}
