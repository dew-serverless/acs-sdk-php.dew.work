<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentationRequest;
use App\Metadata\ApiDocsResolver;
use App\Metadata\ProductResolver;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use InvalidArgumentException;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class ReferenceController
{
    public function index(DocumentationRequest $request, ApiDocsResolver $resolver): RedirectResponse
    {
        try {
            $docs = $resolver->resolve(
                $request->route('product'),
                $request->route('version'),
                $request->language()
            );

            $api = collect($docs->apis)
                ->whenEmpty(fn () => abort(404))
                ->keys()
                ->first();

            return redirect()->route('references.apis.show', [
                'locale' => $request->route('locale'),
                'product' => $request->route('product'),
                'version' => $request->route('version'),
                'api' => $api,
            ]);
        } catch (InvalidArgumentException $e) {
            abort(404);
        }
    }

    public function show(
        DocumentationRequest $request,
        ApiDocsResolver $resolver,
        ProductResolver $products,
        GithubFlavoredMarkdownConverter $markdown
    ): View {
        try {
            $docs = $resolver->resolve(
                $request->route('product'),
                $request->route('version'),
                $language = $request->language()
            );

            $api = $docs->getApi($request->route('api'));

            $product = $products->resolve($request->route('product'), $language);

            return view('references.show', [
                'title' => implode(' - ', [
                    $api->getName(),
                    Str::title($product->name),
                    config('app.name'),
                ]),
                'products' => $products->all($language),
                'product' => $request->route('product'),
                'version' => $request->route('version'),
                'api' => $api,
                'directories' => $docs->directories ?? [],
                'markdown' => $markdown,
            ]);
        } catch (InvalidArgumentException $e) {
            abort(404);
        }
    }
}
