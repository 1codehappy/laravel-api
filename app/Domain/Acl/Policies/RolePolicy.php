<?php

namespace App\Domain\Acl\Policies;

use App\Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return optional($user)->can('roles.viewAny');
    }

    /**
     * Determine whether the user can view role.
     *
     * @param User|null $user
     * @return bool
     */
    public function view(?User $user)
    {
        return optional($user)->can('roles.view');
    }

    /**
     * Determine whether the user can create role.
     *
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user)
    {
        return optional($user)->can('roles.create');
    }

    /**
     * Determine whether the user can update role.
     *
     * @param User|null $user
     * @return bool
     */
    public function update(?User $user)
    {
        return optional($user)->can('roles.update');
    }

    /**
     * Determine whether the user can delete role.
     *
     * @param User|null $user
     * @return bool
     */
    public function delete(?User $user)
    {
        return optional($user)->can('roles.delete');
    }
}
