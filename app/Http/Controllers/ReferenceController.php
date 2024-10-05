<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentationRequest;
use App\Metadata\ApiDocsResolver;
use App\Metadata\Package;
use App\Metadata\ProductResolver;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        Package $package,
        GithubFlavoredMarkdownConverter $markdown
    ): View {
        try {
            $docs = $resolver->resolve(
                $request->route('product'),
                $request->route('version'),
                $request->language()
            );

            $api = $docs->getApi($request->route('api'));

            return view('references.show', [
                'products' => $products->all($request->language()),
                'product' => $request->route('product'),
                'version' => $request->route('version'),
                'api' => $api,
                'directories' => $docs->directories ?? [],
                'markdown' => $markdown,
                'pkg_version' => $package->version(),
                'pkg_metadata' => $package->metadata(),
            ]);
        } catch (InvalidArgumentException $e) {
            abort(404);
        }
    }
}
