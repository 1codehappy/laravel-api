<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits the role.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $newRoleData = Role::factory()->make();
    $payload = $newRoleData->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$role->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => ['name' => $newRoleData->name, 'permissions' => []],
        ]);

    $this->assertDatabaseHas('roles', ['name' => $newRoleData->name]);
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $payload = Role::factory()->make()->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$role->uuid}", $payload)
        ->assertStatus(403);
});

it('tries to create a new role with empty payload.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$role->uuid}", [])
        ->assertStatus(403);
});

it('validates payload when editing a new user', function (array $payload) {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.update');
    $role = Role::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$role->uuid}", $payload)
        ->assertStatus(422);
})->with('role-payloads');

it('updates role permissions.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $payload = ['permissions' => $permissions->pluck('name')->all()];
    $expectedPermissions = $permissions
        ->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$role->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => ['name' => $role->name, 'permissions' => $expectedPermissions],
        ]);
    $this->assertDatabaseHas(
        'role_has_permissions',
        ['role_id' => $role->id, 'permission_id' => $permissions->first()->id]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        ['role_id' => $role->id, 'permission_id' => $permissions->last()->id]
    );
});

it('overrides role permissions.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $role->givePermissionTo($permissions->pluck('name')->all());
    $newPermissions = Permission::factory()->count(2)->create();
    $payload = ['permissions' => $newPermissions->pluck('name')->all()];
    $expectedPermissions = $newPermissions
        ->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$role->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => ['name' => $role->name, 'permissions' => $expectedPermissions],
        ]);

    $this->assertDatabaseMissing(
        'role_has_permissions',
        ['role_id' => $role->id, 'permission_id' => $permissions->first()->id]
    );
    $this->assertDatabaseMissing(
        'role_has_permissions',
        ['role_id' => $role->id, 'permission_id' => $permissions->last()->id]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        ['role_id' => $role->id, 'permission_id' => $newPermissions->first()->id]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        ['role_id' => $role->id, 'permission_id' => $newPermissions->last()->id]
    );
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $uuid = faker()->uuid;
    $payload = Role::factory()->make()->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/roles/{$uuid}", $payload)
        ->assertStatus(404);
});
