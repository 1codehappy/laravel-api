<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('gets the user data.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.view');
    $roles = Role::factory()->count(2)->create();
    $permissions = Permission::factory()->count(3)->create();

    $employee = User::factory()->create();
    $employee->assignRole($roles->pluck('name')->all());
    $employee->givePermissionTo($permissions->pluck('name')->all());
    $response = $this->withHeaders(authHeader($user))
        ->get("/users/{$employee->uuid}");
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $employee->uuid,
                'name' => $employee->name,
                'email' => $employee->email,
                'created_at' => $employee->created_at,
                'updated_at' => $employee->updated_at,
                'roles' => $roles->map(fn (Role $role) => ['id' => $role->uuid, 'name' => $role->name])->all(),
                'permissions' => $permissions->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])->all(),
            ],
        ]);
});

it('can\'t get the user.', function () {
    $user = User::factory()->create();
    $employee = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->get("/users/{$employee->uuid}");
    $response->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.view');
    $uuid = faker()->uuid;
    $response = $this->withHeaders(authHeader($user))
        ->get("/users/{$uuid}");
    $response->assertStatus(404);
});
