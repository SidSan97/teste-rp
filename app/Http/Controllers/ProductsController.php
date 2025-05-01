<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard', [
            'jwtToken' => session('jwt_token'),
        ]);
    }
}
