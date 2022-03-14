<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can edit the user profile.', function () {
    $user = User::factory()->create();
    $newUserData = User::factory()->make();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            '/auth/me',
            [
                'name' => $newUserData->name,
                'email' => $newUserData->email,
            ]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $newUserData->name,
                'email' => $newUserData->email,
                'roles' => [],
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas(
        'users',
        [
            'name' => $newUserData->name,
            'email' => $newUserData->email,
        ]
    );
});

it('can\'t edit the user profile.', function () {
    $response = $this->put('/auth/me');
    $response->assertStatus(401)
        ->assertJson([ 'message' => 'Unauthenticated.' ]);
});

it('validates payload when editing the user profile', function (array $payload) {
    $user = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->put('/auth/me', $payload);
    $response->assertStatus(422);
})->with('profile-payloads');
