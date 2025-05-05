<?php

use App\Models\Product;
use App\Utils\GenerateSkuUtility;
use Tymon\JWTAuth\Facades\JWTAuth;

/* create product */
test('create product page is displayed by admin user', function () {
    $user = createUserWithLevel('admin');

    $response = $this->actingAs($user)->get('/criar-produtos');
    $response->assertOk();
});

/* create product */
test('create product page is not displayed if user non-admin', function () {
    $user = createUserWithLevel('operator');

    $response = $this->actingAs($user)->get('/criar-produtos');
    $response->assertStatus(302);
});

/* create product */
test('product created with success', function () {
    $user = createUserWithLevel('admin');
    $response = $this->actingAs($user);

    $productData = Product::factory()->make()->toArray();
    $response = $this->post('/criar-produtos', $productData);

    $response->assertStatus(201);
    $response->assertJson([
        'message' => 'Produto cadastrado com sucesso.'
    ]);
});

/* create product */
test('product cannot created with empty field', function () {
    $user = createUserWithLevel('admin');
    $response = $this->actingAs($user);

    $productData = Product::factory()->make()->toArray();
    $productData['name'] = null;

    $response = $this->post('/criar-produtos', $productData);
    $response->assertStatus(500);
    $response->assertJson([
        'message' => 'Erro ao cadastrar o produto. Tente novamente mais tarde.'
    ]);
});

/* create product */
test('operate user cannot created a product', function () {
    $user = createUserWithLevel('operator');
    $response = $this->actingAs($user);

    $productData = Product::factory()->make()->toArray();

    $response = $this->post('/criar-produtos', $productData);
    $response->assertStatus(302);
});

/* create product */
test('common user cannot created a product', function () {
    $user = createUserWithLevel('common');
    $response = $this->actingAs($user);

    $productData = Product::factory()->make()->toArray();

    $response = $this->post('/criar-produtos', $productData);
    $response->assertStatus(302);
});

/* product list */ 
test('products should listed from api', function () {
    $user = createUserWithLevel('common');

    $token = JWTAuth::fromUser($user);

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
        'Accept' => 'application/json',
    ])->get('/api/v1/produtos');

    $response->assertOk();
});

/* product list */ 
test('products cannot be listed if JWT token is invalid', function () {
    createUserWithLevel('common');

    $token = "invalid token";

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
        'Accept' => 'application/json',
    ])->get('/api/v1/produtos');

    $response->assertStatus(401);
});

/* edit product */
test('admin can update a product', function () {
    $user = createUserWithLevel('admin');

    $response = $this->actingAs($user);

    Product::factory()->create([
        'name' => 'Produto Antigo',
        'description' => 'Descrição antiga',
        'quantity' => 10,
        'category' => 'Categoria antiga',
        'price' => 100,
        'sku' => GenerateSkuUtility::generateSKU(),
    ]);

    $updatedData = [
        'id' => 1,
        'name' => 'Produto Atualizado',
        'description' => 'Descrição Atualizada',
        'quantity' => 11,
        'category' => 'Categoria nova',
        'price' => 150,
        'sku' => GenerateSkuUtility::generateSKU(),
    ];
    
    $response = $this->put("/editar-produto", $updatedData);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Produto editado com sucesso.'
    ]);
});

/* edit product */
test('common user can not update a product', function () {
    $user = createUserWithLevel('common');

    $response = $this->actingAs($user);

    Product::factory()->create([
        'name' => 'Produto Antigo',
        'description' => 'Descrição antiga',
        'quantity' => 10,
        'category' => 'Categoria antiga',
        'price' => 100,
        'sku' => GenerateSkuUtility::generateSKU(),
    ]);

    $updatedData = [
        'id' => 1,
        'name' => 'Produto Atualizado',
        'description' => 'Descrição Atualizada',
        'quantity' => 11,
        'category' => 'Categoria nova',
        'price' => 150,
        'sku' => GenerateSkuUtility::generateSKU(),
    ];
    
    $response = $this->put("/editar-produto", $updatedData);

    $response->assertStatus(302);
});

/* delete product */
test('product can be deleted', function () {
    $user = createUserWithLevel('admin');

    $response = $this->actingAs($user);

    Product::factory()->create();
    
    $response = $this->delete("/excluir-produto/1");

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Produto excluído com sucesso.'
    ]);
});

/* delete product */
test('operator user can not delete a product ', function () {
    $user = createUserWithLevel('operator');

    $response = $this->actingAs($user);

    Product::factory()->create();
    
    $response = $this->delete("/excluir-produto/1");

    $response->assertStatus(302);
});

/* delete product */
test('common user can not delete a product ', function () {
    $user = createUserWithLevel('common');

    $response = $this->actingAs($user);

    Product::factory()->create();
    
    $response = $this->delete("/excluir-produto/1");

    $response->assertStatus(302);
});
