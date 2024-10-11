<?php

use App\Metadata\ApiDocs;
use App\Metadata\ApiDocsResolver;
use App\Metadata\Product;
use App\Metadata\ProductResolver;

describe('index', function () {
    it('redirects to the reference of the first api', function () {
        $this->mock(ApiDocsResolver::class, function ($mock) {
            $mock->expects()
                ->resolve('foo', '1234', Mockery::any())
                ->andReturns(testDocs(
                    apis: ['one' => testApi()]
                ));
        });

        $this->get('/en-us/foo/1234')
            ->assertRedirect('/en-us/foo/1234/one');
    });

    it('returns 404 if docs does not have any apis', function () {
        $this->mock(ApiDocsResolver::class, function ($mock) {
            $mock->expects()
                ->resolve('foo', '1234', Mockery::any())
                ->andReturns(emptyDocs());
        });

        $this->get('/en-us/foo/1234')->assertNotFound();
    });
});

describe('show', function () {
    it('shows api reference page', function () {
        $this->mock(ApiDocsResolver::class, function ($mock) {
            $mock->expects()
                ->resolve('foo', '1234', Mockery::any())
                ->andReturns(testDocs(
                    apis: ['test' => testApi()]
                ));
        });

        $this->mock(ProductResolver::class, function ($mock) {
            $mock->expects()
                ->resolve('foo', Mockery::any())
                ->andReturns(new Product([
                    'code' => 'foo',
                    'name' => 'Foo',
                ]));

            $mock->expects()
                ->all(Mockery::any())
                ->andReturns([]);
        });

        $this->get('/en-us/foo/1234/test')->assertOk();
    });

    it('returns 404 if api does not exist', function () {
        $this->mock(ApiDocsResolver::class, function ($mock) {
            $mock->expects()
                ->resolve('foo', '1234', Mockery::any())
                ->andReturns(emptyDocs());
        });

        $this->get('/en-us/foo/1234/test')->assertNotFound();
    });

    it('returns 404 if locale is not supported on documentation', function () {
        $this->get('/en-gb/foo/1234/test')->assertNotFound();
    });
});
