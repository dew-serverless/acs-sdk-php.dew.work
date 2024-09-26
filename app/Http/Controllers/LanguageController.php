<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    /**
     * Switch the language.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'locale' => [
                'required',
                'string',
                Rule::in('en', 'zh_Hans'),
            ],
        ]);

        $request->session()->put('locale', $data['locale']);

        return back();
    }
}
