<?php

use App\Metadata\RoaApi;
use App\Metadata\RpcApi;

test('getApi resolves rpc api', function () {
    $docs = testDocs(
        info: [
            'style' => 'RPC',
        ],
        apis: [
            'rpc' => testApi(),
        ]
    );
    expect($docs->getApi('rpc'))->toBeInstanceOf(RpcApi::class);
});

test('getApi resolves roa api', function () {
    $docs = testDocs(
        info: [
            'style' => 'ROA',
        ],
        apis: [
            'roa' => testApi(),
        ]
    );
    expect($docs->getApi('roa'))->toBeInstanceOf(RoaApi::class);
});

test('getApi resolves roa api if docs style is not rpc', function () {
    $docs = testDocs(
        info: [
            'style' => 'product',
        ],
        apis: [
            'roa' => testApi(),
        ]
    );
    expect($docs->getApi('roa'))->toBeInstanceOf(RoaApi::class);
});
