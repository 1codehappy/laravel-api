<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes a user.', function () {
    $action = new DeleteUser();
    $user = User::factory()->hasRoles(2)->hasPermissions(3)->create();
    $roles = $user->roles;
    $permissionsFromRoles = $roles
        ->map(function ($role) {
            return $role->permissions->pluck('name')->all();
        })
        ->flatten()
        ->all();
    $permissions = $user->permissions;
    expect($action->execute($user))->toBeTrue();

    $this->assertDatabaseMissing('users', ['id' => $user->id]);

    $roles->each(function ($role) use ($user) {
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
        $this->assertDatabaseMissing(
            'model_has_roles',
            [
                'model_type' => App\Domain\User\Models\User::class,
                'model_id' => $user->id,
                'role_id' => $role->id,
            ]
        );
    });

    foreach ($permissionsFromRoles as $permission) {
        $this->assertDatabaseHas('permissions', ['name' => $permission]);
    }

    $permissions->each(function ($permission) use ($user) {
        $this->assertDatabaseHas('permissions', ['id' => $permission->id]);
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
