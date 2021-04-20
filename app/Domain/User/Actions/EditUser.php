<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;
use Illuminate\Support\Arr;

class EditUser
{
    /**
     * Update user's data
     *
     * @param UserDto $data
     * @param User $user
     * @return User
     */
    public function execute(UserDto $data, User $user): User
    {
        $user->fill(Arr::except($data->toArray(), 'password'))->save();
        return $user;
    }
}
