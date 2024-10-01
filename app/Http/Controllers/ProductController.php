<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentationRequest;
use App\Metadata\ProductResolver;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ProductController extends Controller
{
    public function show(DocumentationRequest $request, ProductResolver $resolver): mixed
    {
        try {
            $product = $resolver->resolve(
                $request->route('product'),
                $request->language()
            );

            return redirect()->route('references.apis.index', [
                'product' => $request->route('product'),
                'version' => $product->defaultVersion,
            ]);
        } catch (InvalidArgumentException $e) {
            abort(404);
        }
    }
}
