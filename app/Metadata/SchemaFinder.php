<?php

declare(strict_types=1);

namespace App\Metadata;

readonly class SchemaFinder
{
    /**
     * @param  array<string, mixed[]>  $data
     */
    public function __construct(
        private array $data
    ) {
        //
    }

    public function find(string $path): mixed
    {
        $result = $this->data;

        $fragments = explode('/', $path);

        foreach ($fragments as $fragment) {
            if ($fragment === '#') {
                continue;
            }

            if (! array_key_exists($fragment, $result)) {
                return null;
            }

            $result = $result[$fragment];
        }

        return $result;
    }
}
