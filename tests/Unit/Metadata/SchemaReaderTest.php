<?php

use App\Metadata\SchemaFinder;
use App\Metadata\SchemaReader;

test('read parses schema', function () {
    $reader = new SchemaReader(new SchemaFinder([]));
    expect($reader->read(['type' => 'string']))->toBe(['type' => 'string']);
});

test('read parses object schema', function () {
    $reader = new SchemaReader(new SchemaFinder([
        'components' => [
            'schemas' => [
                'foo' => [
                    'type' => 'string',
                ],
            ],
        ],
    ]));
    $schema = $reader->read([
        'type' => 'object',
        'properties' => [
            'foo' => [
                '$ref' => '#/components/schemas/foo',
            ],
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'object',
        'properties' => [
            'foo' => [
                '$ref' => '#/components/schemas/foo',
                'type' => 'string',
            ],
        ],
    ]);
});

test('read parses array schema', function () {
    $reader = new SchemaReader(new SchemaFinder([
        'components' => [
            'schemas' => [
                'foo' => [
                    'type' => 'object',
                ],
            ],
        ],
    ]));
    $schema = $reader->read([
        'type' => 'array',
        'items' => [
            '$ref' => '#/components/schemas/foo',
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'array',
        'items' => [
            '$ref' => '#/components/schemas/foo',
            'type' => 'object',
        ],
    ]);
});

test('readObjectProperties parses properties in schema', function () {
    $reader = new SchemaReader(new SchemaFinder([
        'components' => [
            'schemas' => [
                'foo' => [
                    'type' => 'string',
                ],
            ],
        ],
    ]));
    $schema = $reader->readObjectProperties([
        'type' => 'object',
        'properties' => [
            'foo' => [
                '$ref' => '#/components/schemas/foo',
            ],
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'object',
        'properties' => [
            'foo' => [
                '$ref' => '#/components/schemas/foo',
                'type' => 'string',
            ],
        ],
    ]);
});

test('readObjectAdditionalProperties parses additional properties in schema', function () {
    $reader = new SchemaReader(new SchemaFinder([]));
    $schema = $reader->readObjectAdditionalProperties([
        'type' => 'object',
        'additionalProperties' => [
            'type' => 'string',
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'object',
        'additionalProperties' => [
            'type' => 'string',
        ],
    ]);
});

test('readObject parses properties in schema if one is provided', function () {
    $reader = new SchemaReader(new SchemaFinder([
        'components' => [
            'schemas' => [
                'foo' => [
                    'type' => 'string',
                ],
            ],
        ],
    ]));
    $schema = $reader->readObject([
        'type' => 'object',
        'properties' => [
            'foo' => [
                '$ref' => '#/components/schemas/foo',
            ],
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'object',
        'properties' => [
            'foo' => [
                '$ref' => '#/components/schemas/foo',
                'type' => 'string',
            ],
        ],
    ]);
});

test('readObject parses additional properties in schema if one is provided', function () {
    $reader = new SchemaReader(new SchemaFinder([]));
    $schema = $reader->readObject([
        'type' => 'object',
        'additionalProperties' => [
            'type' => 'string',
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'object',
        'additionalProperties' => [
            'type' => 'string',
        ],
    ]);
});

test('readArray parses items in schema', function () {
    $reader = new SchemaReader(new SchemaFinder([
        'components' => [
            'schemas' => [
                'foo' => [
                    'type' => 'object',
                ],
            ],
        ],
    ]));
    $schema = $reader->readArray([
        'type' => 'array',
        'items' => [
            '$ref' => '#/components/schemas/foo',
        ],
    ]);
    expect($schema)->toBe([
        'type' => 'array',
        'items' => [
            '$ref' => '#/components/schemas/foo',
            'type' => 'object',
        ],
    ]);
});
