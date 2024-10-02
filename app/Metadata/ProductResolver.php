<?php

namespace App\Metadata;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

class ProductResolver
{
    /**
     * @var array<string, mixed[]>|null
     */
    private ?array $data = null;

    public function __construct(
        private Filesystem $files,
        private Repository $cache
    ) {
        //
    }

    public function resolve(string $code, string $language): Product
    {
        $products = $this->get($language);

        $normalized = strtolower($code);

        if (! isset($products[$normalized])) {
            throw new InvalidArgumentException(
                "Could not find $code product."
            );
        }

        return new Product($this->data[$normalized]);
    }

    /**
     * @return array<int, mixed[]>
     */
    public function all(string $language): array
    {
        return $this->get($language);
    }

    /**
     * @return array<int, mixed[]>
     */
    public function get(string $language): array
    {
        if ($this->data === null) {
            $this->data = $this->make($language);
        }

        return $this->data;
    }

    /**
     * @return array<int, mixed[]>
     */
    private function make(string $language): array
    {
        return $this->cache->rememberForever(
            static::cacheKey($language),
            function () use ($language): array {
                $path = resource_path(sprintf(
                    'metadata/%s/product.php', $language
                ));

                if ($this->files->missing($path)) {
                    throw new InvalidArgumentException(
                        "No products found with language $language."
                    );
                }

                $data = [];
                $products = $this->files->getRequire($path);

                foreach ($products as $product) {
                    $code = strtolower($product['code']);

                    $data[$code] = $product;
                }

                return $data;
            });
    }

    public static function cacheKey(string $language): string
    {
        return "products.$language";
    }
}
