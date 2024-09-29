<?php

namespace App\Http\Controllers;

use App\Metadata\ApiDocsResolver;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use InvalidArgumentException;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class ReferenceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        ApiDocsResolver $resolver,
        GithubFlavoredMarkdownConverter $markdown
    ): View {
        $locale = $request->session()->get('locale', 'en');

        $language = match ($locale) {
            'zh_Hans' => 'zh_cn',
            default => 'en_us',
        };

        try {
            $docs = $resolver->resolve(
                $request->route('product'),
                $request->route('version'),
                $language
            );

            $api = $docs->getApi($request->route('api'));

            return view('reference', [
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
