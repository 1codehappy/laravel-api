<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits the user\'s data.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $newUserData = User::factory()->make();
    $payload = $newUserData->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $newUserData->name,
                'email' => $newUserData->email,
                'roles' => [],
                'permissions' => [],
            ],
        ]);
    $this->assertDatabaseHas('users', ['name' => $newUserData->name, 'email' => $newUserData->email]);
});

it('gives that the user doesn\'t have the right permission.', function () {
    $user = User::factory()->create();
    $employee = User::factory()->create();
    $payload = User::factory()->make()->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(403);
});

it('tries to create a new user with empty payload.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", [])
        ->assertStatus(403);
});

it('can\'t use an email already registered.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $newUserData = User::factory()->make(['email' => $user->email]);
    $payload = $newUserData->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(422);
});

it('validates payload when editing a new user', function (array $payload) {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(422);
})->with('user-payloads');

it('updates user\'s roles.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $roles = Role::factory()->count(2)->create();
    $payload = ['roles' => $roles->pluck('name')->all()];
    $expectedRoles = $roles
        ->map(fn (Role $role) => ['id' => $role->uuid, 'name' => $role->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => $expectedRoles,
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
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $roles = Role::factory()->count(2)->create();
    $employee->assignRole($roles->pluck('name')->all());
    $newRoles = Role::factory()->count(2)->create();
    $payload = ['roles' => $newRoles->pluck('name')->all()];
    $expectedRoles = $newRoles
        ->map(fn ($role) => ['id' => $role->uuid, 'name' => $role->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => $expectedRoles,
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
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $payload = ['permissions' => $permissions->pluck('name')->all()];
    $expectedPermissions = $permissions
        ->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => [],
                'permissions' => $expectedPermissions,
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
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $employee = User::factory()->create();
    $permissions = Permission::factory()->count(2)->create();
    $employee->givePermissionTo($permissions->pluck('name')->all());
    $newPermissions = Permission::factory()->count(2)->create();
    $payload = ['permissions' => $newPermissions->pluck('name')->all()];
    $expectedPermissions = $newPermissions
        ->map(fn (Permission $permission) => ['id' => $permission->uuid, 'name' => $permission->name])
        ->all();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$employee->uuid}", $payload)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $employee->name,
                'email' => $employee->email,
                'roles' => [],
                'permissions' => $expectedPermissions,
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
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.update');
    $uuid = faker()->uuid;
    $payload = User::factory()->make()->toArray();

    $this->withToken(Auth::login($user))
        ->json('PUT', "/users/{$uuid}", $payload)
        ->assertStatus(404);
});
