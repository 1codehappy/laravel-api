<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('creates a new user with roles ands permissions.', function () {
    $action = new CreateUser();
    $dto = new UserDto([
        'name' => faker()->name,
        'email' => faker()->email,
        'password' => faker()->password(8),
    ]);
    $createdUser = $action->execute($dto);
    expect($createdUser->name)->toBe($dto->name);
    expect($createdUser->email)->toBe($dto->email);
});

it('creates a new user with roles.', function () {
    $roles = Role::factory()->hasPermissions()->count(2)->create();
    $permissions = Permission::factory()->count(3)->create();

    $action = new CreateUser();
    $dto = new UserDto([
        'name' => faker()->name,
        'email' => faker()->email,
        'password' => faker()->password(8),
        'roles' => $roles->pluck('name')->all(),
        'permissions' => $permissions->pluck('name')->all(),
    ]);
    $user = $action->execute($dto);
    expect($user->roles)->toHaveCount(2);
    expect($user->permissions)->toHaveCount(3);

    $roles->each(function ($role) use ($user) {
        $this->assertDatabaseHas(
            'model_has_roles',
            [
                'model_type' => App\Domain\User\Models\User::class,
                'model_id' => $user->id,
                'role_id' => $role->id,
            ]
        );
    });

    $permissions->each(function ($permission) use ($user) {
        $this->assertDatabaseHas(
            'model_has_permissions',
            [
                'model_type' => App\Domain\User\Models\User::class,
                'model_id' => $user->id,
                'permission_id' => $permission->id,
            ]
        );
    });
});
