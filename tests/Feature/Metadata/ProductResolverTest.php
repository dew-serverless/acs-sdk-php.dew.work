<?php

use App\Metadata\Product;
use App\Metadata\ProductResolver;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Filesystem\Filesystem;

test('resolve resolves and caches product data', function () {
    $mockedFiles = Mockery::mock(new Filesystem());
    $mockedFiles->expects()
        ->missing(resource_path('metadata/en_us/products.php'))
        ->andReturns(false);
    $mockedFiles->expects()
        ->getRequire(resource_path('metadata/en_us/products.php'))
        ->andReturns([
            ['code' => 'foo'],
        ]);
    $cache = new Repository(new ArrayStore());
    $resolver = new ProductResolver($mockedFiles, $cache);
    expect($cache->missing('products.en_us'))->toBeTrue()
        ->and($resolver->resolve('foo', 'en_us'))->toBeInstanceOf(Product::class)
        ->and($cache->has('products.en_us'))->toBeTrue();
});

test('resolve code is case insensitive', function () {
    $mockedFiles = Mockery::mock(new Filesystem());
    $mockedFiles->expects()
        ->missing(resource_path('metadata/en_us/products.php'))
        ->andReturns(false);
    $mockedFiles->expects()
        ->getRequire(resource_path('metadata/en_us/products.php'))
        ->andReturns([
            ['code' => 'foo'],
        ]);
    $cache = new Repository(new ArrayStore());
    $resolver = new ProductResolver($mockedFiles, $cache);
    expect($resolver->resolve('FOO', 'en_us'))
        ->toBeInstanceOf(Product::class);
    expect($resolver->resolve('Foo', 'en_us'))
        ->toBeInstanceOf(Product::class);
});

test('resolve throws exception when does not have metadata in specific language', function () {
    $mockedFiles = Mockery::mock(new Filesystem());
    $mockedFiles->expects()
        ->missing(resource_path('metadata/en_us/products.php'))
        ->andReturns(true);
    $cache = new Repository(new ArrayStore());
    $resolver = new ProductResolver($mockedFiles, $cache);
    expect(fn () => $resolver->resolve('foo', 'en_us'))
        ->toThrow(InvalidArgumentException::class, 'No products found with language en_us.');
});

test('resolve throws exception when product does not exist', function () {
    $mockedFiles = Mockery::mock(new Filesystem());
    $mockedFiles->expects()
        ->missing(resource_path('metadata/en_us/products.php'))
        ->andReturns(false);
    $mockedFiles->expects()
        ->getRequire(resource_path('metadata/en_us/products.php'))
        ->andReturns([]);
    $cache = new Repository(new ArrayStore());
    $resolver = new ProductResolver($mockedFiles, $cache);
    expect(fn () => $resolver->resolve('foo', 'en_us'))
        ->toThrow(InvalidArgumentException::class, 'Could not find foo product.');
});
