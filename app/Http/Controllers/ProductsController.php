<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'category' => 'required|string|max:255',
                'sku' => 'required|string|max:255',
            ]);

            $this->product->create($validated);

            return redirect()->route('create.products')->with('success', 'Produto cadastrado com sucesso.');

        } catch (\Exception $e) {
            Log::info("ProductsController error: ", [$e]);

            return redirect()
                ->route('create.products')
                ->with('error', 'Erro interno ao cadastrar o produto. Tente novamente mais tarde.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'category' => 'required',
                'sku' => 'required',
            ]);

            $product = $this->product->findOrFail($id);

            $product->update($request->all());

            return redirect()->route('dashboard')->with('success', 'Produto atualizado com sucesso!');

        } catch(\Exception $e) {
            Log::info("ProductsController error: ", [$e]);
            return redirect()->route('dashboard')->with('error', 'Erro ao editar o produto. Tente novamente mais tarde.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $product = $this->product->findOrFail($id);
            $product->delete();

            return redirect()->route('dashboard')->with('success', 'Produto excluído com sucesso.');
        } catch (\Exception $e) {
            Log::info("ProductsController error: ", [$e]);
            return redirect()->route('dashboard')->with('error', 'Erro ao excluir o produto. Tente novamente mais tarde.');
        }
    }
}
