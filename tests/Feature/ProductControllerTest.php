<?php

use App\Metadata\Product;
use App\Metadata\ProductResolver;

describe('show', function () {
    it('redirects to the default version of the api', function () {
        $this->mock(ProductResolver::class, function ($mock) {
            $mock->expects()
                ->resolve('foo', Mockery::any())
                ->andReturns(new Product([
                    'code' => 'foo',
                    'style' => 'RPC',
                    'defaultVersion' => '1234',
                ]));
        });

        $this->get('/en-us/foo')
            ->assertRedirect('/en-us/foo/1234');
    });
});
