<?php

use App\Models\User;

test('create product screen can be rendered', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/criar-produtos');
    $response->assertStatus(200);
});