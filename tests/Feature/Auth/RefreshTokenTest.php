<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('refreshes the jwt token', function () {
    $user = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->post('/auth/refresh');
    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Token generated.',
            'data' => [
                'token_type' => 'Bearer',
            ],
        ]);
});

it('can\'t refresh the jwt token', function () {
    $response = $this->json('POST', '/auth/refresh');
    $response->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});
