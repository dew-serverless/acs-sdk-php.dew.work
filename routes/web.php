<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReferenceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/en-us/vpc');

Route::get('/{locale}/{product}', [ProductController::class, 'show'])->name('references.product.show');
Route::get('/{locale}/{product}/{version}', [ReferenceController::class, 'index'])->name('references.apis.index');
Route::get('/{locale}/{product}/{version}/{api}', [ReferenceController::class, 'show'])->name('references.apis.show');
