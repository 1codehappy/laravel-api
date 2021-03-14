<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\Data\UserData;
use Illuminate\Support\Arr;

class EditUser
{
    /**
     * Update user's data
     *
     * @param UserData $data
     * @param User $user
     * @return User
     */
    public function execute(UserData $data, User $user): User
    {
        $user->fill(Arr::except($data->toArray(), 'password'))->save();

        return $user;
    }
}
