<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ConfigureLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->has('locale')
            ? $request->session()->get('locale')
            : $this->getPreferredLocaleFrom($request);

        App::setLocale($locale);

        return $next($request);
    }

    private function getPreferredLocaleFrom(Request $request): string
    {
        $first = Str::of($request->header('Accept-Language'))
            ->explode(',')
            ->first();

        [$language] = Str::of($first)->explode(';')->all();

        return match (true) {
            str_starts_with($language, 'zh') => 'zh_Hans',
            default => 'en',
        };
    }
}
