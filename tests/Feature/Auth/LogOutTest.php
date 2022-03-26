<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('was logged out successfully.', function () {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('POST', '/auth/logout')
        ->assertStatus(200)
        ->assertJson(['message' => __('auth.logout')]);
});

it('can\'t log out.', function () {
    $this->json('POST', '/auth/logout')
        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});

it('isn\'t possible to log out by GET.', function () {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('GET', '/auth/logout')
        ->assertStatus(405);
});
