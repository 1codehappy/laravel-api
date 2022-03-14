<?php

namespace App\Domain\Acl\Actions;

use App\Domain\Acl\Models\Role;

class DeleteRole
{
    /**
     * Delete the role.
     *
     * @param Role $role
     * @return bool
     */
    public function execute(Role $role): bool
    {
        return $role->delete();
    }
}
