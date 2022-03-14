<?php

use App\Domain\Permission\Models\Permission;
use App\Domain\Permission\Models\Role;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits the role.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $newRoleData = Role::factory()->make();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/roles/{$role->uuid}",
            $newRoleData->toArray()
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $newRoleData->name,
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas(
        'roles',
        ['name' => $newRoleData->name]
    );
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $response = $this->withHeaders(authHeader($user))
    ->put(
        "/roles/{$role->uuid}",
        User::factory()->make()->toArray()
    );
    $response->assertStatus(403);
});

it('tries to create a new role with empty payload.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/roles/{$role->uuid}",
            []
        );
    $response->assertStatus(403);
});

it('validates payload when editing a new user', function (array $payload) {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/roles/{$role->uuid}",
            $payload
        );
    $response->assertStatus(422);
})->with('role-payloads');

it('updates role permissions.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/roles/{$role->uuid}",
            ['permissions' => $permissions->pluck('name')->all()]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $role->name,
                'permissions' => $permissions->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])
                    ->all(),
            ],
        ]);
    $this->assertDatabaseHas(
        'role_has_permissions',
        [
            'role_id' => $role->id,
            'permission_id' => $permissions->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        [
            'role_id' => $role->id,
            'permission_id' => $permissions->last()->id,
        ]
    );
});

it('overrides role permissions.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.update');
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $role->givePermissionTo($permissions->pluck('name')->all());
    $newPermissions = Permission::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/roles/{$role->uuid}",
            ['permissions' => $newPermissions->pluck('name')->all()]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $role->name,
                'permissions' => $newPermissions->map(
                    fn (Permission $permission) => [
                            'id' => $permission->uuid,
                            'name' => $permission->name,
                        ]
                )
                    ->all(),
            ],
        ]);
    $this->assertDatabaseMissing(
        'role_has_permissions',
        [
            'role_id' => $role->id,
            'permission_id' => $permissions->first()->id,
        ]
    );
    $this->assertDatabaseMissing(
        'role_has_permissions',
        [
            'role_id' => $role->id,
            'permission_id' => $permissions->last()->id,
        ]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        [
            'role_id' => $role->id,
            'permission_id' => $newPermissions->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'role_has_permissions',
        [
            'role_id' => $role->id,
            'permission_id' => $newPermissions->last()->id,
        ]
    );
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $uuid = faker()->uuid;
    $response = $this->withHeaders(authHeader($user))
        ->put("/roles/{$uuid}", Role::factory()->make()->toArray());
    $response->assertStatus(404);
});
