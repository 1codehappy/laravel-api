<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can show the user profile.', function () {
    $user = User::factory()->create();

    $response = $this->withHeaders(authHeader($user))
        ->get('/auth/me');
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('uuid')->toArray(),
                'permissions' => $user->roles->pluck('permissions')->toArray(),
            ],
        ]);
});

it('can\'t show the user profile.', function () {
    $response = $this->get('/auth/me');
    $response->assertStatus(401)
        ->assertJson([ 'message' => 'Unauthenticated.' ]);
});
