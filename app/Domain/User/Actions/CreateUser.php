<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;

class CreateUser
{
    /**
     * Create new user
     *
     * @param UserDto $data
     * @return User
     */
    public function execute(UserDto $data): User
    {
        return User::create($data->toArray());
    }
}
