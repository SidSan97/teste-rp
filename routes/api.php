<?php

use App\Http\Controllers\Api\ProductsControllerResponse;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('v1/produtos', [ProductsControllerResponse::class, 'index']);
});
