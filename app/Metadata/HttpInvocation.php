<?php

namespace App\Metadata;

readonly class HttpInvocation
{
    public function __construct(
        public string $method,
        public string $endpoint
    ) {
        //
    }
}
