<?php

namespace App\Domain\Permission\Actions;

use App\Domain\Permission\Models\Role;

class DeleteRole
{
    /**
     * Delete role
     *
     * @param Role $role
     * @return bool
     */
    public function execute(Role $role): bool
    {
        return $role->delete();
    }
}
