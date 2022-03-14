<?php

namespace App\Domain\Acl\Actions;

use App\Domain\Acl\Models\Role;
use App\Support\Acl\DTOs\RoleDto;

class EditRole
{
    /**
     * Update role data.
     *
     * @param RoleDto $data
     * @param Role $role
     * @return Role
     */
    public function execute(RoleDto $data, Role $role): Role
    {
        $roleName = $data->name;
        if ($roleName) {
            $role->name = $roleName;
            $role->save();
        }
        if ($data->hasPermissions()) {
            $role->syncPermissions($data->permissions);
        }

        return $role;
    }
}
