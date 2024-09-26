<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/references/{product}/{version}/{api}', ReferenceController::class);
Route::post('/languages', [LanguageController::class, 'store']);
