<?php

use App\Metadata\ApiDocs;
use App\Metadata\ApiDocsResolver;
use Illuminate\Filesystem\Filesystem;

test('resolve resolves from resource metadata directory', function () {
    $mock = Mockery::mock(Filesystem::class);
    $resolver = new ApiDocsResolver($mock);
    $mock->expects()
        ->exists(resource_path('metadata/en_us/test/1234/api-docs.php'))
        ->andReturns(true);
    $mock->expects()
        ->getRequire(resource_path('metadata/en_us/test/1234/api-docs.php'))
        ->andReturns([]);
    expect($resolver->resolve('test', '1234', 'en_us'))->toBeInstanceOf(ApiDocs::class);
});

test('resolve throws exception when could not find docs file', function () {
    $mock = Mockery::mock(Filesystem::class);
    $resolver = new ApiDocsResolver($mock);
    $mock->expects()
        ->exists(resource_path('metadata/en_us/test/1234/api-docs.php'))
        ->andReturns(false);
    expect(fn () => $resolver->resolve('test', '1234', 'en_us'))
        ->toThrow(InvalidArgumentException::class, 'Could not find API docs file for product test with version 1234.');
});
