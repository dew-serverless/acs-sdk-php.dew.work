<?php

namespace App\Http\Controllers;

use App\Metadata\ApiDocs;
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
        ApiDocs $docs,
        GithubFlavoredMarkdownConverter $markdown
    ): View {
        try {
            $api = $docs->findApi(
                $request->route('product'),
                $request->route('version'),
                $request->route('api')
            );

            return view('reference', [
                'product' => $request->route('product'),
                'version' => $request->route('version'),
                'api' => $api,
                'markdown' => $markdown,
            ]);
        } catch (InvalidArgumentException $e) {
            abort(404);
        }
    }
}
