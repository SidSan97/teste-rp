<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Response;

use function Pest\Laravel\json;

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

            return app()->runningUnitTests()
                ? response()->json(['message' => 'Produto cadastrado com sucesso.'], 201)
                : redirect()->route('create.products')->with('success', 'Produto cadastrado com sucesso.');

        } catch (\Exception $e) {
            Log::info("ProductsController store error: ", [$e]);

            return app()->runningUnitTests()
                ? response()->json(['message' => 'Erro ao cadastrar o produto. Tente novamente mais tarde.'], 500)
                : redirect()->route('create.products')->with('error', 'Erro ao cadastrar o produto. Tente novamente mais tarde.');
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

            return app()->runningUnitTests()
                ? response()->json(['message' => 'Produto editado com sucesso.'], 200)
                : redirect()->route('dashboard')->with('success', 'Produto editado com sucesso.');

        } catch(\Exception $e) {
            Log::info("ProductsController update error: ", [$e]);
            
            return app()->runningUnitTests()
                ? response()->json(['message' => 'Erro ao editar o produto. Tente novamente mais tarde..'], 500)
                : redirect()->route('dashboard')->with('error', 'Erro ao editar o produto. Tente novamente mais tarde.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $product = $this->product->findOrFail($id);
            $product->delete();

            return app()->runningUnitTests()
                ? response()->json(['message' => 'Produto excluído com sucesso.'], 200)
                : redirect()->route('dashboard')->with('success', 'Produto excluído com sucesso.');

        } catch (\Exception $e) {
            Log::info("ProductsController destroy error: ", [$e]);

            return app()->runningUnitTests()
                ? response()->json(['message' => 'Erro ao excluir o produto. Tente novamente mais tarde.'], 500)
                : redirect()->route('dashboard')->with('error', 'Erro ao excluir o produto. Tente novamente mais tarde.');
        }
    }
}
