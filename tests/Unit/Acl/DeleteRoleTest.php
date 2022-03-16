<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes a role.', function () {
    $action = new DeleteRole();
    $role = Role::factory()->hasPermissions()->create();
    $permissions = $role->permissions;
    expect($action->execute($role))->toBeTrue();

    $this->assertDatabaseMissing('roles', ['id' => $role->id]);

    $permissions->each(function ($permission) use ($role) {
        $this->assertDatabaseHas('permissions', ['id' => $permission->id]);
        $this->assertDatabaseMissing(
            'role_has_permissions',
            ['role_id' => $role->id, 'permission_id' => $permission->id]
        );
    });
});
