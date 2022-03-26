<?php

namespace App\Domain\Auth\Actions;

use App\Support\Auth\DTOs\PasswordDto;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPassword
{
    /**
     * Reset the password.
     *
     * @param PasswordDto $dto
     * @return string|null
     */
    public function execute(PasswordDto $dto): ?string
    {
        return Password::reset(
            $dto->toArray(),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }
}
