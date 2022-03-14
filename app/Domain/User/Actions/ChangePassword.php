<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;

class ChangePassword
{
    /**
     * Change the user's password.
     *
     * @param UserDto $dto
     * @param User $user
     * @return User
     */
    public function execute(UserDto $dto, User $user): User
    {
        $user->password = bcrypt($dto->password);
        $user->save();

        return $user;
    }
}
