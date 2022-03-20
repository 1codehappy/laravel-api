<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can show the user profile.', function () {
    $user = User::factory()
        ->hasRoles()
        ->hasPermissions()
        ->create();
    $expectedRoles = $user
        ->roles
        ->map(fn ($role) => ['id' => $role->uuid, 'name' => $role->name])
        ->all();
    $expectedPermissions = $user
        ->permissions
        ->map(fn ($permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('GET', '/auth/me')
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $expectedRoles,
                'permissions' => $expectedPermissions,
            ],
        ]);
});

it('can\'t show the user profile.', function () {
    $this->json('GET', '/auth/me')
        ->assertStatus(401)
        ->assertJson([ 'message' => 'Unauthenticated.' ]);
});
