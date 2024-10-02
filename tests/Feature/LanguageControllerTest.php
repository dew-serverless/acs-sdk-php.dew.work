<?php

use Illuminate\Support\Facades\Session;

it('switches language', function (string $locale) {
    $this->post('/languages', [
        'locale' => $locale,
    ])->assertRedirect();

    expect(Session::get('locale'))->toBe($locale);
})->with([
    'en',
    'zh_Hans',
]);

it('validates locale', function () {
    $this->post('/languages', [
        'locale' => 'foo',
    ])->assertInvalid(['locale']);
});
