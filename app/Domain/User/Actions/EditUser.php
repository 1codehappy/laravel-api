<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;

class EditUser
{
    /**
     * Update user's data.
     *
     * @param UserDto $data
     * @param User $user
     * @return User
     */
    public function execute(UserDto $data, User $user): User
    {
        $user->fill(array_rm_null_values($data->except('password')->toArray()))
            ->save();
        if (count($data->roles ?? []) > 0) {
            $user->syncRoles($data->roles);
        }
        if (count($data->permissions ?? []) > 0) {
            $user->syncPermissions($data->permissions);
        }

        return $user->fresh();
    }
}
