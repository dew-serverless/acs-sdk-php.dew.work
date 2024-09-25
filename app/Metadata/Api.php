<?php

namespace App\Metadata;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Api
{
    /**
     * @var array<string, mixed[]>
     */
    private ?Collection $grouppedParameters = null;

    /**
     * @param  array<string, mixed>  $definition
     */
    public function __construct(
        private readonly string $name,
        private readonly array $definition
    ) {
        //
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed[]
     */
    public function getQueryParameters(): array
    {
        return $this->getParametrsByLocation('query');
    }

    /**
     * @return mixed[]
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

        return $this->grouppedParameters[$location]->all();
    }

    public function __get(string $property): mixed
    {
        return Arr::get($this->definition, $property);
    }
}
