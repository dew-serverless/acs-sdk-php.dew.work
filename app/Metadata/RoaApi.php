<?php

namespace App\Metadata;

use Override;

class RoaApi extends Api
{
    /**
     * @return \App\Metadata\HttpInvocation[]
     */
    #[Override]
    public function getHttpInvocations(): array
    {
        if (! isset($this->definition['path'])) {
            return [];
        }

        if (! isset($this->definition['methods'])) {
            return [];
        }

        if (! is_array($this->definition['methods'])) {
            return [];
        }

        return collect($this->definition['methods'])
            ->map(fn (string $method): HttpInvocation => new HttpInvocation(strtoupper($method), $this->definition['path']))
            ->all();
    }
}
