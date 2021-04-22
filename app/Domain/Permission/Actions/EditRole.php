<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Role;
use App\Support\Permission\DTOs\RoleDto;

class EditRole
{
    /**
     * Update role's data
     *
     * @param RoleDto $dto
     * @param Role $role
     * @return Role
     */
    public function execute(RoleDto $dto, Role $role): Role
    {
        $roleName = $dto->name;
        if ($roleName) {
            $role->name = $roleName;
            $role->save();
        }
        if ($dto->hasPermissions()) {
            $role->givePermissionTo($dto->permissions);
        }
        return $role;
    }
}
