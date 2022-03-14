<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits the user\'s data.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $newUserData = User::factory()->make();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            $newUserData->toArray()
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $newUserData->name,
                'email' => $newUserData->email,
                'roles' => [],
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas(
        'users',
        [
            'name' => $newUserData->name,
            'email' => $newUserData->email,
        ]
    );
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $employee = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
    ->put(
        "/users/{$employee->uuid}",
        User::factory()->make()->toArray()
    );
    $response->assertStatus(403);
});

it('tries to create a new user with empty payload.', function () {
    $user = User::factory()->create();
    $employee = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            []
        );
    $response->assertStatus(403);
});

it('can\'t use an email already registered.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $newUserData = User::factory()->make(['email' => $user->email]);
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            $newUserData->toArray()
        );
    $response->assertStatus(422);
});

it('validates payload when editing a new user', function (array $payload) {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            $payload
        );
    $response->assertStatus(422);
})->with('user-payloads');

it('updates user\'s roles.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $roles = Role::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            ['roles' => $roles->pluck('name')->all()]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => $roles->map(fn (Role $role) => ['id' => $role->uuid, 'name' => $role->name])
                    ->all(),
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'role_id' => $roles->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'role_id' => $roles->last()->id,
        ]
    );
});

it('overrides user\'s roles.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $roles = Role::factory()->count(2)->create();
    $employee->assignRole($roles->pluck('name')->all());

    $newRoles = Role::factory()->count(2)->create();

    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            ['roles' => $newRoles->pluck('name')->all()]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => $newRoles->map(fn (Role $role) => ['id' => $role->uuid, 'name' => $role->name])
                    ->all(),
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseMissing(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'role_id' => $roles->first()->id,
        ]
    );
    $this->assertDatabaseMissing(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'role_id' => $roles->last()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'role_id' => $newRoles->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_roles',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'role_id' => $newRoles->last()->id,
        ]
    );
});

it('updates user\'s permissions.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            ['permissions' => $permissions->pluck('name')->all()]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => [],
                'permissions' => $permissions->map(
                    fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name]
                )
                    ->all(),
            ],
        ]);
    $this->assertDatabaseHas(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'permission_id' => $permissions->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'permission_id' => $permissions->last()->id,
        ]
    );
});

it('overrides user\'s permissions.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $employee->givePermissionTo($permissions->pluck('name')->all());
    $newPermissions = Permission::factory()->count(2)->create();
    $response = $this->withHeaders(authHeader($user))
        ->put(
            "/users/{$employee->uuid}",
            ['permissions' => $newPermissions->pluck('name')->all()]
        );
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => [],
                'permissions' => $newPermissions->map(
                    fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name]
                )
                    ->all(),
            ],
        ]);
    $this->assertDatabaseMissing(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'permission_id' => $permissions->first()->id,
        ]
    );
    $this->assertDatabaseMissing(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'permission_id' => $permissions->last()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'permission_id' => $newPermissions->first()->id,
        ]
    );
    $this->assertDatabaseHas(
        'model_has_permissions',
        [
            'model_type' => App\Domain\User\Models\User::class,
            'model_id' => $employee->id,
            'permission_id' => $newPermissions->last()->id,
        ]
    );
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $uuid = faker()->uuid;
    $response = $this->withHeaders(authHeader($user))
        ->put("/users/{$uuid}", User::factory()->make()->toArray());
    $response->assertStatus(404);
});
