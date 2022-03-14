<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;

class DeleteUser
{
    /**
     * Delete the user.
     *
     * @param User $user
     * @return bool
     */
    public function execute(User $user): bool
    {
        return $user->delete();
    }
}
