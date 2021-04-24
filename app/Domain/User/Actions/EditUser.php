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
     * @param UserDto $dto
     * @param User $user
     * @return User
     */
    public function execute(UserDto $dto, User $user): User
    {
        $user
            ->fill(Arr::except(array_rm_null_values($dto->toArray()), 'password'))
            ->save()
        ;
        if (count($dto->roles ?? []) > 0) {
            $user->syncRoles($dto->roles);
        }
        if (count($dto->permissions ?? []) > 0) {
            $user->syncPermissions($dto->permissions);
        }

        return $user->fresh();
    }
}
