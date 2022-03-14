<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;

class CreateUser
{
    /**
     * Create a new user.
     *
     * @param UserDto $data
     * @return User
     */
    public function execute(UserDto $data): User
    {
        $user = User::create($data->toArray());
        if (count($data->roles ?? []) > 0) {
            $user->syncRoles($data->roles);
        }
        if (count($data->permissions ?? []) > 0) {
            $user->syncPermissions($data->permissions);
        }

        return $user->fresh();
    }
}
