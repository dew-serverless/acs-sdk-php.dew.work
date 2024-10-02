<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentationRequest extends FormRequest
{
    /**
     * The documentation language.
     */
    public function language(): string
    {
        $locale = $this->session()->get('locale', 'en');

        return match ($locale) {
            'zh_Hans' => 'zh_cn',
            default => 'en_us',
        };
    }
}
