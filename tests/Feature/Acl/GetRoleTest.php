<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('gets the role data.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.view');
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $role->givePermissionTo($permissions->pluck('name')->all());
    $expectedPermissions = $permissions
        ->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('GET', "/roles/{$role->uuid}")
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $role->uuid,
                'name' => $role->name,
                'created_at' => $role->present()->createdAt,
                'updated_at' => $role->present()->updatedAt,
                'permissions' => $expectedPermissions,
            ],
        ]);
});

it('can\'t get the role.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('GET', "/roles/{$role->uuid}")
        ->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.view');
    $uuid = faker()->uuid;

    $this->withToken(Auth::login($user))
        ->json('GET', "/roles/{$uuid}")
        ->assertStatus(404);
});
