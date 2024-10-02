<?php

use App\Metadata\RpcApi;

test('http invocation resolution', function () {
    $api = new RpcApi('foo', testApi([
        'methods' => ['post', 'get'],
    ]));
    expect($api->getHttpInvocations())
        ->toHaveCount(2)
        ->{0}->method->toBe('POST')
        ->{0}->endpoint->toBe('/foo')
        ->{1}->method->toBe('GET')
        ->{1}->endpoint->toBe('/foo');
});
