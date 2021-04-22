<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Role;
use App\Support\Permission\DTOs\RoleDto;

class CreateRole
{
    /**
     * Create new role
     *
     * @param RoleDto $dto
     * @return Role
     */
    public function execute(RoleDto $dto): Role
    {
        $role = Role::create(['name' => $dto->name]);
        if ($dto->hasPermissions()) {
            $role->givePermissionTo($dto->permissions);
        }
        return $role;
    }
}
