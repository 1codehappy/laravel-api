<?php

namespace App\Domain\User\Policies;

use App\Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return optional($user)->can('users.viewAny');
    }

    /**
     * Determine whether the user can view another user.
     *
     * @param User|null $user
     * @return bool
     */
    public function view(?User $user)
    {
        return optional($user)->can('users.view');
    }

    /**
     * Determine whether the user can create another user.
     *
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user)
    {
        return optional($user)->can('users.create');
    }

    /**
     * Determine whether the user can update another user.
     *
     * @param User|null $user
     * @return bool
     */
    public function update(?User $user)
    {
        return optional($user)->can('users.update');
    }

    /**
     * Determine whether the user can delete another user.
     *
     * @param User|null $user
     * @return bool
     */
    public function delete(?User $user)
    {
        return optional($user)->can('users.delete');
    }
}
