<?php

namespace App\Domain\Auth\Actions;

use App\Support\Auth\DTOs\EmailDto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;

class SendResetLink
{
    /**
     * Send the reset link.
     *
     * @param EmailDto $dto
     * @return string|null
     */
    public function execute(EmailDto $dto): ?string
    {
        $status = Password::sendResetLink(
            $dto->toArray(),
            function ($user, $token) {
                // If you want to send an email with the reset link, please uncomment the line bellow:
                // $user->sendPasswordResetNotification($token);
                // or remove this closure.

                // I've used the caching strategy to get the reset token instead of the email.
                Cache::set($user->email, $token);
            }
        );

        return $status;
    }
}
