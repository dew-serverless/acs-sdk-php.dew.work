<?php

namespace App\Metadata;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class Api
{
    /**
     * @var array<string, mixed[]>
     */
    private ?Collection $grouppedParameters = null;

    private SchemaFinder $schemaFinder;

    /**
     * @param  array<string, mixed>  $definition
     */
    public function __construct(
        protected readonly string $name,
        protected readonly array $definition
    ) {
        //
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \App\Metadata\HttpInvocation[]
     */
    abstract function getHttpInvocations(): array;

    /**
     * @return \App\Metadata\Parameter[]
     */
    public function getQueryParameters(): array
    {
        return $this->getParametrsByLocation('query');
    }

    /**
     * @return \App\Metadata\Parameter|null
     */
    public function getRequestBody(): ?Parameter
    {
        return $this->getParametrsByLocation('body')[0] ?? null;
    }

    /**
     * @return \App\Metadata\Parameter[]
     */
    public function getParametrsByLocation(string $location): array
    {
        if ($this->grouppedParameters === null) {
            $this->grouppedParameters = collect($this->definition['parameters'])
                ->groupBy('in');
        }

        if (! $this->grouppedParameters->has($location)) {
            return [];
        }

        return $this->grouppedParameters[$location]
            ->map(fn (array $definition): Parameter => (new Parameter($definition))
                ->setSchemaFinder($this->schemaFinder))
            ->all();
    }

    public function setSchemaFinder(SchemaFinder $finder): self
    {
        $this->schemaFinder = $finder;

        return $this;
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->definition, $property);
    }
}
