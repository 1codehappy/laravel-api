<?php

namespace App\Domain\Acl\Actions;

use App\Domain\Acl\Models\Role;
use App\Support\Acl\DTOs\RoleDto;

class CreateRole
{
    /**
     * Create a new role.
     *
     * @param RoleDto $data
     * @return Role
     */
    public function execute(RoleDto $data): Role
    {
        $role = Role::create(['name' => $data->name]);
        if ($data->hasPermissions()) {
            $role->givePermissionTo($data->permissions);
        }

        return $role;
    }
}
