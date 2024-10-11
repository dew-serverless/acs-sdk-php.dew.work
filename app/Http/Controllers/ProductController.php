<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentationRequest;
use App\Metadata\ProductResolver;
use InvalidArgumentException;

class ProductController
{
    public function show(DocumentationRequest $request, ProductResolver $resolver): mixed
    {
        try {
            $product = $resolver->resolve(
                $request->route('product'),
                $request->language()
            );

            return redirect()->route('references.apis.index', [
                'locale' => $request->route('locale'),
                'product' => $request->route('product'),
                'version' => $product->defaultVersion,
            ]);
        } catch (InvalidArgumentException $e) {
            abort(404);
        }
    }
}
