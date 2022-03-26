<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('refreshes the jwt token', function () {
    $user = User::factory()->create();
    $this->withToken(Auth::login($user))
        ->json('POST', '/auth/refresh')
        ->assertStatus(201)
        ->assertJson(['message' => __('auth.success'), 'data' => ['token_type' => 'Bearer']]);
});

it('can\'t refresh the jwt token', function () {
    $this->json('POST', '/auth/refresh')
        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});
