<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('generates the jwt token.', function () {
    $user = User::factory()->create();
    $payload = ['email' => $user->email, 'password' => 'password'];

    $this->json('POST', '/auth/login', $payload)
        ->assertStatus(201)
        ->assertJson(['message' => 'Token generated.', 'data' => ['token_type' => 'Bearer']]);
});

it('validates payload to the user log in', function (array $payload) {
    $this->json('POST', '/auth/login', $payload)
        ->assertStatus(422);
})->with('login-payloads');
