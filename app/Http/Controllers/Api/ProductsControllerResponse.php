<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductsControllerResponse extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'products' => Product::all()
        ]);
    }
}
