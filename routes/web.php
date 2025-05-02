<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [ProductsController::class, 'index'])->name('dashboard');

    Route::get('/criar-produtos', function () {
        return Inertia::render('create-products');
    })->name('create-products');

    Route::post('/criar-produtos', [ProductsController::class, 'store'])->name('dashboard-store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
