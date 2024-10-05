<?php

namespace App\Metadata;

use Illuminate\Filesystem\Filesystem;

class Package
{
    public function __construct(
        private Filesystem $files
    ) {
        //
    }

    public function version(): string
    {
        return $this->files->get(resource_path('metadata/VERSION'));
    }

    public function metadata(): string
    {
        return $this->files->get(resource_path('metadata/METADATA'));
    }
}
