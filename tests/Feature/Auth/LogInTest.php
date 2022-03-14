<?php

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('generates the jwt token.', function () {
    $user = User::factory()->create();

    $response = $this->post('/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Token generated.',
            'data' => [
                'token_type' => 'Bearer',
            ],
        ]);
});

it('validates payload to the user log in', function (array $payload) {
    $response = $this->post('/auth/login', $payload);
    $response->assertStatus(422);
})->with('login-payloads');
