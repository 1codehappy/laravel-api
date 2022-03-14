<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits role data.', function () {
    $action = new EditRole();
    $dto = new RoleDto(['name' => faker()->name]);
    $role = Role::factory()->create();
    $updatedRole = $action->execute($dto, $role);
    expect($updatedRole->name)->toBe($dto->name);

    $this->assertDatabaseHas(
        'roles',
        ['name' => $updatedRole->name]
    );
});

it('edits permissions from a role.', function () {
    $action = new EditRole();
    $permissions = Permission::factory()->count(4)->create();
    $dto = new RoleDto([
        'name' => faker()->name,
        'permissions' => $permissions->pluck('name')->all(),
    ]);
    $role = Role::factory()->hasPermissions()->create();
    $oldPermissions = $role->permissions;
    $updatedRole = $action->execute($dto, $role);
    expect($updatedRole->name)->toBe($dto->name);
    expect($updatedRole->permissions)->toHaveCount(4);

    $permissions->each(function (Permission $permission) use ($role) {
        $this->assertDatabaseHas(
            'role_has_permissions',
            ['role_id' => $role->id, 'permission_id' => $permission->id]
        );
    });

    $oldPermissions->each(function (Permission $permission) use ($role) {
        $this->assertDatabaseMissing(
            'role_has_permissions',
            ['role_id' => $role->id, 'permission_id' => $permission->id]
        );
    });
});
