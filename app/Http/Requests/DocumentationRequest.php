<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

class DocumentationRequest extends FormRequest
{
    /**
     * The documentation language.
     */
    public function language(): string
    {
        $locale = $this->route('locale');

        return match ($locale) {
            'zh-cn' => 'zh_cn',
            'en-us' => 'en_us',
            default => throw new InvalidArgumentException(
                'Unsupported documentation language.'
            ),
        };
    }
}
