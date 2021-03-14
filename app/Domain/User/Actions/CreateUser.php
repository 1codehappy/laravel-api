<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\Data\UserData;

class CreateUser
{
    /**
     * Create new user
     *
     * @param UserData $data
     * @return User
     */
    public function execute(UserData $data): User
    {
        return User::create($data->toArray());
    }
}
