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

    public function hasPathParameters(): bool
    {
        return $this->getGrouppedParameters()->has('path');
    }

    /**
     * @return \App\Metadata\Parameter[]
     */
    public function getPathParameters(): array
    {
        return $this->getParametrsByLocation('path');
    }

    public function hasHeaderParameters(): bool
    {
        return $this->getGrouppedParameters()->has('header');
    }

    /**
     * @return \App\Metadata\Parameter[]
     */
    public function getHeaderParameters(): array
    {
        return $this->getParametrsByLocation('header');
    }

    public function hasQueryParameters(): bool
    {
        return $this->getGrouppedParameters()->has('query');
    }

    /**
     * @return \App\Metadata\Parameter[]
     */
    public function getQueryParameters(): array
    {
        return $this->getParametrsByLocation('query');
    }

    public function hasRequestBody(): bool
    {
        return $this->getGrouppedParameters()->has('body');
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
        if (! $this->getGrouppedParameters()->has($location)) {
            return [];
        }

        $reader = new SchemaReader($this->schemaFinder);

        return $this->grouppedParameters[$location]
            ->map(fn (array $definition): Parameter => new Parameter($definition, $reader))
            ->all();
    }

    private function getGrouppedParameters(): Collection
    {
        if ($this->grouppedParameters === null) {
            $this->grouppedParameters = collect($this->definition['parameters'])
                ->groupBy('in');
        }

        return $this->grouppedParameters;
    }

    /**
     * @return \App\Metadata\Response|null
     */
    public function getResponse(string $code): ?Response
    {
        if (! isset($this->definition['responses'][$code])) {
            return null;
        }

        return new Response(
            $this->definition['responses'][$code],
            new SchemaReader($this->schemaFinder)
        );
    }

    public function firstResponseCode(): ?string
    {
        if (! isset($this->definition['responses'])) {
            return null;
        }

        $codes = array_keys($this->definition['responses']);

        if (! isset($codes[0])) {
            return null;
        }

        return (string) $codes[0];
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
