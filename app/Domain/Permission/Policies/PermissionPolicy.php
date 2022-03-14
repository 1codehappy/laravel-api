<?php

namespace App\Domain\Permission\Policies;

use App\Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any permissions.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return optional($user)->can('permissions.viewAny');
    }
}
