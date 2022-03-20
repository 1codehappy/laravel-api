<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a new role.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.create');
    $role = Role::factory()->make();
    $payload = $role->toArray();

    $this->withToken(Auth::login($user))
        ->json('POST', '/roles', $payload)
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $role->name,
                'permissions' => [],
            ],
        ]);

    $this->assertDatabaseHas('roles', ['name' => $role->name]);
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->make();
    $payload = $role->toArray();

    $this->withToken(Auth::login($user))
        ->json('POST', '/roles', $payload)
        ->assertStatus(403);
});

it('tries to create a new role with empty payload.', function () {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('POST', '/roles', [])
        ->assertStatus(403);
});

it('validates payload when creating a new user', function (array $payload) {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.create');

    $this->withToken(Auth::login($user))
            ->json('POST', '/roles', $payload)
            ->assertStatus(422);
})->with('role-payloads');

it('creates a new role with permissions.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.create');
    $role = Role::factory()->make();
    $permissions = Permission::factory()->count(2)->create();
    $payload = array_merge($role->toArray(), ['permissions' => $permissions->pluck('name')->all()]);
    $expectedPermissions = $permissions
        ->map(fn (Permission $permission) => [
            'id' => $permission->uuid,
            'name' => $permission->name,
        ])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('POST', '/roles', $payload)
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => $role->name,
                'permissions' => $expectedPermissions,
            ],
        ]);

    $this->assertDatabaseHas('roles', ['name' => $role->name]);

    $createdRole = Role::where('name', $role->name)->first();
    $this->assertDatabaseHas(
        'role_has_permissions',
        ['role_id' => $createdRole->id, 'permission_id' => $permissions->first()->id]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        ['role_id' => $createdRole->id, 'permission_id' => $permissions->last()->id]
    );
});
