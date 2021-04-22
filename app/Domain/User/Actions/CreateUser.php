<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;

class CreateUser
{
    /**
     * Create new user
     *
     * @param UserDto $dto
     * @return User
     */
    public function execute(UserDto $dto): User
    {
        $user = User::create($dto->toArray());
        if (count($dto->roles ?? []) > 0) {
            $user->syncRoles($dto->roles);
        }
        if (count($dto->permissions ?? []) > 0) {
            $user->syncPermissions($dto->permissions);
        }
        return $user->fresh();
    }
}
