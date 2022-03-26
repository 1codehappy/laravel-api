<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('forgot the password.', function () {
    $user = User::factory()->create();
    $payload = ['email' => $user->email];

    $response = $this->json('POST', '/auth/forgot-password', $payload);
    $response
        ->assertStatus(201)
        ->assertJson([
            'message' => __('passwords.sent'),
            'data' => [
                'email' => $user->email,
            ],
        ]);
});

it('validates the payload.', function (array $payload) {
    $this->json('POST', '/auth/forgot-password', $payload)
        ->assertStatus(422);
})->with('forgot-password-payloads');
