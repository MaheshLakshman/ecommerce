<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** Variants */
    Route::prefix('variants')->as('variants.')->group(function () {
        Route::get('/', [App\Http\Controllers\VariantController::class, 'index'])->name('index');
        Route::get('list', [App\Http\Controllers\VariantController::class, 'table'])->name('list');
        Route::get('create', [App\Http\Controllers\VariantController::class, 'create'])->name('create');
        Route::post('create', [App\Http\Controllers\VariantController::class, 'store'])->name('store');
        // Route::get('edit/{id}', [App\Http\Controllers\VariantController::class, 'edit'])->name('edit');
        // Route::post('edit/{id}', [App\Http\Controllers\VariantController::class, 'update'])->name('update');
        // Route::delete('delete/{id}', [App\Http\Controllers\VariantController::class, 'destroy'])->name('destroy');
        // Route::patch('status/{id}', [App\Http\Controllers\VariantController::class, 'status'])->name('status');
    });

     /** options */
     Route::prefix('options')->as('options.')->group(function () {
        Route::get('variant/{id}', [App\Http\Controllers\OptionController::class, 'index'])->name('index');
        //Route::get('list', [App\Http\Controllers\OptionController::class, 'table'])->name('list');
        //Route::get('create', [App\Http\Controllers\OptionController::class, 'create'])->name('create');
        Route::post('create', [App\Http\Controllers\OptionController::class, 'store'])->name('store');
        // Route::get('edit/{id}', [App\Http\Controllers\OptionController::class, 'edit'])->name('edit');
        // Route::post('edit/{id}', [App\Http\Controllers\OptionController::class, 'update'])->name('update');
        // Route::delete('delete/{id}', [App\Http\Controllers\OptionController::class, 'destroy'])->name('destroy');
        // Route::patch('status/{id}', [App\Http\Controllers\OptionController::class, 'status'])->name('status');
    });

       /** options */
       Route::prefix('products')->as('products.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
        Route::get('list', [App\Http\Controllers\ProductController::class, 'table'])->name('list');
        Route::get('create', [App\Http\Controllers\ProductController::class, 'create'])->name('create');
        Route::post('create', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
        Route::patch('status/{id}', [App\Http\Controllers\ProductController::class, 'status'])->name('status');
    });

});

require __DIR__ . '/auth.php';
