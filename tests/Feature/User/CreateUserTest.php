<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a new user.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.create');
    $newUser = User::factory()->make();
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            $newUser->toArray()
        );
    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $newUser->name,
                'email' => $newUser->email,
                'roles' => [],
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas(
        'users',
        [
            'name' => $newUser->name,
            'email' => $newUser->email,
        ]
    );
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $newUser = User::factory()->make();
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            $newUser->toArray()
        );
    $response->assertStatus(403);
});

it('tries to create a new user with empty payload.', function () {
    $user = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            []
        );
    $response->assertStatus(403);
});

it('can\'t use an email already registered.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.create');
    $newUser = User::factory()->make(['email' => $user->email]);
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            $newUser->toArray()
        );
    $response->assertStatus(422);
});

it('validates payload when creating a new user', function (array $payload) {
    $user = User::factory()->create();
    $user->givePermissionTo('users.create');
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            $payload
        );
    $response->assertStatus(422);
})->with('user-payloads');

it('creates a new user with roles.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.create');
    $newUser = User::factory()->make();
    $roles = Role::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            array_merge(
                $newUser->toArray(),
                ['roles' => $roles->pluck('name')->all()]
            )
        );
    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $newUser->name,
                'email' => $newUser->email,
                'roles' => $roles->map(fn (Role $role) => ['id' => $role->uuid, 'name' => $role->name])
                    ->all(),
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas(
        'users',
        [
            'name' => $newUser->name,
            'email' => $newUser->email,
        ]
    );
    $createdUser = User::where('email', $newUser->email)->first();
    $this->assertDatabaseHas(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $createdUser->id,
            'role_id' => $roles->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $createdUser->id,
            'role_id' => $roles->last()->id,
        ]
    );
});

it('creates a new user with permissions.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.create');
    $newUser = User::factory()->make();
    $permissions = Permission::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->post(
            '/users',
            array_merge(
                $newUser->toArray(),
                ['permissions' => $permissions->pluck('name')->all()]
            )
        );
    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $newUser->name,
                'email' => $newUser->email,
                'roles' => [],
                'permissions' => $permissions->map(
                    fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name]
                )
                    ->all(),
            ],
        ]);
    $this->assertDatabaseHas(
        'users',
        [
            'name' => $newUser->name,
            'email' => $newUser->email,
        ]
    );
    $createdUser = User::where('email', $newUser->email)->first();
    $this->assertDatabaseHas(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $createdUser->id,
            'permission_id' => $permissions->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $createdUser->id,
            'permission_id' => $permissions->last()->id,
        ]
    );
});
