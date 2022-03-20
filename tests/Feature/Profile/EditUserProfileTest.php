<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can edit the user profile.', function () {
    $user = User::factory()->create();
    $newUserData = User::factory()->make();
    $payload = ['name' => $newUserData->name, 'email' => $newUserData->email];

    $this->withToken(Auth::login($user))
        ->json('PUT', '/auth/me', $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $newUserData->name,
                'email' => $newUserData->email,
                'roles' => [],
                'permissions' => [],
            ],
        ]);

    $this->assertDatabaseHas('users', ['name' => $newUserData->name, 'email' => $newUserData->email]);
});

it('can\'t edit the user profile.', function () {
    $this->json('PUT', '/auth/me', [])
        ->assertStatus(401)
        ->assertJson([ 'message' => 'Unauthenticated.']);
});

it('validates payload when editing the user profile', function (array $payload) {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('PUT', '/auth/me', $payload)
        ->assertStatus(422);
})->with('profile-payloads');
