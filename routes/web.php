<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/references/{product}/{version}', [ReferenceController::class, 'index'])->name('reference.index');
Route::get('/references/{product}/{version}/{api}', [ReferenceController::class, 'show'])->name('reference.show');
Route::post('/languages', [LanguageController::class, 'store']);
