<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [ProductsController::class, 'index'])->name('dashboard');
});

Route::get('/login-api', function () {
    return Inertia::render('auth/login-api');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
