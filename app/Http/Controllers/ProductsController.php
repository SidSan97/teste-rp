<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\ResponseTraits;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Response;

class ProductsController extends Controller
{
    protected $product;

    use ResponseTraits;

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
    public function create(): Response
    {
        return Inertia::render('create-products');
    }

    public function store(Request $request)
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
            
            return $this->response("Produto cadastrado com sucesso.", 201, false, 'create.products');
            
        } catch (\Exception $e) {
            Log::info("ProductsController store error: ", [$e]);

            return $this->response("Erro ao cadastrar o produto. Tente novamente mais tarde.", 500, true, 'create.products');
        }
    }

    public function update(Request $request)
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

            $product = $this->product->findOrFail($request['id']);

            $product->update($request->all());

            return $this->response("Produto editado com sucesso.", 200, false, 'dashboard');

        } catch(\Exception $e) {
            Log::info("ProductsController update error: ", [$e]);

            return $this->response("Erro ao editar o produto. Tente novamente mais tarde.", 500, true, 'dashboard');
        }
    }

    public function destroy(int $id)
    {
        try {
            $product = $this->product->findOrFail($id);
            $product->delete();

            return $this->response("Produto excluído com sucesso.", 200, false, 'dashboard');

        } catch (\Exception $e) {
            Log::info("ProductsController destroy error: ", [$e]);

            return $this->response("Erro ao excluir o produto. Tente novamente mais tarde.", 500, true, 'dashboard');
        }
    }
}
