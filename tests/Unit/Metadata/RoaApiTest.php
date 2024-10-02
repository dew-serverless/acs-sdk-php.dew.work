<?php

use App\Metadata\RoaApi;

test('http invocation resolution', function () {
    $api = new RoaApi('foo', testApi([
        'path' => '/foo',
        'methods' => ['post'],
    ]));
    expect($api->getHttpInvocations())
        ->toHaveCount(1)
        ->{0}->method->toBe('POST')
        ->{0}->endpoint->toBe('/foo');
});
