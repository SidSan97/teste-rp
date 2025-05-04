<?php

use App\Http\Controllers\ProductsController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [ProductsController::class, 'index'])->name('dashboard');

    Route::get('/criar-produtos', [ProductsController::class, 'create'])->name('create.products')->middleware('user_level');
    Route::post('/criar-produtos', [ProductsController::class, 'store'])->name('store.products')->middleware('user_level');
    Route::delete('/excluir-produto/{id}', [ProductsController::class, 'destroy'])->name('delete.product')->middleware('user_level');
    Route::put('/editar-produto/{id}', [ProductsController::class, 'update'])->name('update.product');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
