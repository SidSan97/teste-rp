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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
        ]);

        try {
            $product = Product::create($validated);
    
            if (!$product) {
                return redirect()
                    ->route('dashboard')
                    ->with('error', 'Erro ao cadastrar o produto.')
                    ->setStatusCode(500);
            }
    
            return redirect()
                ->route('dashboard')
                ->with('success', 'Produto cadastrado com sucesso!')
                ->setStatusCode(201);
    
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Erro interno ao cadastrar o produto: ' . $e->getMessage())
                ->setStatusCode(500);
        }
    }
}
