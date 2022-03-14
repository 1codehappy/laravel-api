<?php

use App\Domain\Permission\Models\Permission;
use App\Domain\Permission\Models\Role;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('gets the role data.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.view');
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $role->givePermissionTo($permissions->pluck('name')->all());
    $response = $this->withHeaders(authHeader($user))
        ->get("/roles/{$role->uuid}");
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $role->uuid,
                'name' => $role->name,
                'created_at' => $role->present()->createdAt,
                'updated_at' => $role->present()->updatedAt,
                'permissions' => $permissions->map(
                    fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name]
                )->all(),
            ],
        ]);
});

it('can\'t get the role.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->get("/roles/{$role->uuid}");
    $response->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.view');
    $uuid = faker()->uuid;
    $response = $this->withHeaders(authHeader($user))
        ->get("/roles/{$uuid}");
    $response->assertStatus(404);
});
