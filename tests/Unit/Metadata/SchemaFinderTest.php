<?php

use App\Metadata\SchemaFinder;

test('find sharp symbol is the data itself', function () {
    $finder = new SchemaFinder(['foo' => 'bar']);
    expect($finder->find('#'))->toBe(['foo' => 'bar']);
});

test('find can retrieve data', function () {
    $finder = new SchemaFinder(['foo' => 'bar']);
    expect($finder->find('foo'))->toBe('bar');
});

test('find can retrieve nested data', function () {
    $finder = new SchemaFinder(['nested' => ['foo' => 'bar']]);
    expect($finder->find('nested/foo'))->toBe('bar');
});

test('find retrieves data with sharp symbol', function () {
    $finder = new SchemaFinder(['foo' => 'bar']);
    expect($finder->find('#/foo'))->toBe('bar');
});

test('find returns null if data does not exist', function () {
    $finder = new SchemaFinder(['foo' => 'bar']);
    expect($finder->find('bar'))->toBeNull();
});
