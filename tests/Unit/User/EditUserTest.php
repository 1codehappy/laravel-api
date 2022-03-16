<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits user\'s data.', function () {
    $action = new EditUser();
    $dto = new UserDto(['name' => faker()->name, 'email' => faker()->email]);
    $user = User::factory()->create();
    $updatedUser = $action->execute($dto, $user);
    expect($updatedUser->name)->toBe($dto->name);
    expect($updatedUser->email)->toBe($dto->email);
});

it('can\'t edit the user\'s password.', function () {
    $action = new EditUser();
    $dto = new UserDto(['name' => faker()->name, 'password' => 'secret1234']);
    $user = User::factory()->create();
    $updatedUser = $action->execute($dto, $user);
    expect($updatedUser->name)->toBe($dto->name);
    expect($updatedUser->password)->not->toBe($dto->email);
});

it('edits roles/permissions from the user.', function () {
    $action = new EditUser();
    $user = User::factory()->hasRoles()->hasPermissions()->create();
    $roles = Role::factory()->hasPermissions()->count(2)->create();
    $permissions = Permission::factory()->count(3)->create();
    $dto = new UserDto([
        'roles' => $roles->pluck('name')->all(),
        'permissions' => $permissions->pluck('name')->all(),
    ]);
    $oldRoles = $user->roles;
    $oldPermissions = $user->permissions;
    $updatedRole = $action->execute($dto, $user);
    expect($updatedRole->roles)->toHaveCount(2);
    expect($updatedRole->permissions)->toHaveCount(3);

    $oldRoles->each(function ($role) use ($user) {
        $this->assertDatabaseMissing(
            'model_has_roles',
            [
                'model_type' => App\Domain\User\Models\User::class,
                'model_id' => $user->id,
                'role_id' => $role->id,
            ]
        );
    });

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

    $oldPermissions->each(function ($permission) use ($user) {
        $this->assertDatabaseMissing(
            'model_has_permissions',
            [
                'model_type' => App\Domain\User\Models\User::class,
                'model_id' => $user->id,
                'permission_id' => $permission->id,
            ]
        );
    });
});
