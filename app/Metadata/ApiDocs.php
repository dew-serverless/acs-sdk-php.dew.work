<?php

namespace App\Metadata;

use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

readonly class ApiDocs
{
    public function __construct(
        private Filesystem $files
    ) {
        //
    }

    public function findApi(string $product, string $version, string $api): Api
    {
        $path = resource_path(sprintf('metadata/%s/%s/%s/api-docs.php',
            'en_us', $product, $version
        ));

        if (! $this->files->exists($path)) {
            throw new InvalidArgumentException(sprintf(
                'Could not find API docs file for product %s with version %s.',
                $product, $version
            ));
        }

        $docs = require $path;

        if (! isset($docs['apis'][$api])) {
            throw new InvalidArgumentException(sprintf(
                'Could not find %s API in product %s with version %s.',
                $api, $product, $version
            ));
        }

        return new Api($api, $docs['apis'][$api]);
    }
}
