<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Inertia\Response;

class ProductsController extends Controller
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index(): Response
    {
        return Inertia::render('dashboard', [
            'jwtToken' => session('jwt_token'),
            'userLevel' => session('user_level'),
        ]);
    }

    public function store(Request $request): RedirectResponse
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

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if(!$product) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Produto não encontrado')
                ->setStatusCode(404);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'required',
            'sku' => 'required',
        ]);

        $product->update($request->all());

        return redirect()
            ->route('dashboard')
            ->with('success', 'Produto atualizado com sucesso!')
            ->setStatusCode(200);
    }

    public function destroy(int $id)
    {
        try {
            $product = $this->product->findOrFail($id);
            $product->delete();

            return redirect()->route('dashboard')->with('success', 'Produto excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erro ao excluir o produto.');
        }
    }
}
