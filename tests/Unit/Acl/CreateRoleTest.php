<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('creates a new role.', function () {
    $action = new CreateRole();
    $dto = new RoleDto(['name' => faker()->name]);
    $role = $action->execute($dto);
    expect($role->name)->toBe($dto->name);

    $this->assertDatabaseHas(
        'roles',
        ['name' => $dto->name]
    );
});

it('creates a new role with permissions.', function () {
    $action = new CreateRole();
    $permissions = Permission::factory()->count(4)->create();
    $dto = new RoleDto([
        'name' => faker()->name,
        'permissions' => $permissions->pluck('name')->all(),
    ]);
    $role = $action->execute($dto);
    expect($role->permissions)->toHaveCount(4);

    $permissions->each(function (Permission $permission) use ($role) {
        $this->assertDatabaseHas(
            'role_has_permissions',
            ['role_id' => $role->id, 'permission_id' => $permission->id]
        );
    });
});
