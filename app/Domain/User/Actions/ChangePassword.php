<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;

class ChangePassword
{
    /**
     * Change the user's password.
     *
     * @param UserDto $data
     * @param User $user
     * @return User
     */
    public function execute(UserDto $data, User $user): User
    {
        $user->password = bcrypt($data->password);
        $user->save();

        return $user;
    }
}
