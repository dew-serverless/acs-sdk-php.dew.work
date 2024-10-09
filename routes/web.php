<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{locale}/{product}', [ProductController::class, 'show'])->name('references.product.show');
Route::get('/{locale}/{product}/{version}', [ReferenceController::class, 'index'])->name('references.apis.index');
Route::get('/{locale}/{product}/{version}/{api}', [ReferenceController::class, 'show'])->name('references.apis.show');
Route::post('/languages', [LanguageController::class, 'store']);
