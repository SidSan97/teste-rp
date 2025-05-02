<?php

use App\Http\Controllers\Api\ProductsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('v1/produtos', [ProductsController::class, 'index']);
});
