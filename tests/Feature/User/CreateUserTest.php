<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a new user.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.create');
    $newUser = User::factory()->make();
    $payload = $newUser->toArray();

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', $payload)
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $newUser->name,
                'email' => $newUser->email,
                'roles' => [],
                'permissions' => [],
            ],
        ]);

    $this->assertDatabaseHas('users', ['name' => $newUser->name, 'email' => $newUser->email]);
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $newUser = User::factory()->make();
    $payload = $newUser->toArray();

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', $payload)
        ->assertStatus(403);
});

it('tries to create a new user with empty payload.', function () {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', [])
        ->assertStatus(403);
});

it('can\'t use an email already registered.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.create');
    $newUser = User::factory()->make(['email' => $user->email]);
    $payload = $newUser->toArray();

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', $payload)
        ->assertStatus(422);
});

it('validates payload when creating a new user', function (array $payload) {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.create');

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', $payload)
        ->assertStatus(422);
})->with('user-payloads');

it('creates a new user with roles.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.create');
    $newUser = User::factory()->make();
    $roles = Role::factory()->count(2)->create();
    $payload = array_merge($newUser->toArray(), ['roles' => $roles->pluck('name')->all()]);
    $expectedRoles = $roles
        ->map(fn ($role) => ['id' => $role->uuid, 'name' => $role->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', $payload)
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $newUser->name,
                'email' => $newUser->email,
                'roles' => $expectedRoles,
                'permissions' => [],
            ],
        ]);

    $this->assertDatabaseHas('users', ['name' => $newUser->name, 'email' => $newUser->email]);

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
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.create');
    $newUser = User::factory()->make();
    $permissions = Permission::factory()->count(2)->create();
    $payload = array_merge($newUser->toArray(), ['permissions' => $permissions->pluck('name')->all()]);
    $expectedPermissions = $permissions
        ->map(fn ($permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('POST', '/users', $payload)
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $newUser->name,
                'email' => $newUser->email,
                'roles' => [],
                'permissions' => $expectedPermissions,
            ],
        ]);

    $this->assertDatabaseHas('users', ['name' => $newUser->name, 'email' => $newUser->email]);

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
