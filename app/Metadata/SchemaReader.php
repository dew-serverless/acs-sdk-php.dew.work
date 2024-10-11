<?php

namespace App\Metadata;

readonly class SchemaReader
{
    public function __construct(
        private SchemaFinder $finder
    ) {
        //
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    public function read(array $schema): array
    {
        if (isset($schema['$ref'])) {
            $ref = $this->finder->find($schema['$ref']);

            if ($ref === null) {
                return $schema;
            }

            return [
                ...$schema,
                ...$this->read($ref),
            ];
        }

        return match ($schema['type']) {
            'object' => $this->readObject($schema),
            'array' => $this->readArray($schema),
            default => $schema,
        };
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    public function readObject(array $schema): array
    {
        return match (true) {
            isset($schema['properties']) => $this->readObjectProperties($schema),
            isset($schema['additionalProperties']) => $this->readObjectAdditionalProperties($schema),
            default => $schema,
        };
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    public function readObjectProperties(array $schema): array
    {
        if (! isset($schema['properties'])) {
            return $schema;
        }

        foreach ($schema['properties'] as $property => $propSchema) {
            $schema['properties'][$property] = $this->read($propSchema);
        }

        return $schema;
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    public function readObjectAdditionalProperties(array $schema): array
    {
        if (! isset($schema['additionalProperties'])) {
            return $schema;
        }

        $schema['additionalProperties'] = $this->read($schema['additionalProperties']);

        return $schema;
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    public function readArray(array $schema): array
    {
        if (! isset($schema['items'])) {
            return $schema;
        }

        $schema['items'] = $this->read($schema['items']);

        return $schema;
    }
}
