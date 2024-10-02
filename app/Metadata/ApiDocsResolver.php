<?php

namespace App\Metadata;

use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

class ApiDocsResolver
{
    public function __construct(
        private Filesystem $files
    ) {
        //
    }

    public function resolve(string $product, string $version, string $language): ApiDocs
    {
        $path = resource_path(sprintf('metadata/%s/%s/%s/api-docs.php',
            $language, $product, $version
        ));

        if (! $this->files->exists($path)) {
            throw new InvalidArgumentException(sprintf(
                'Could not find API docs file for product %s with version %s.',
                $product, $version
            ));
        }

        return new ApiDocs(require $path);
    }
}
