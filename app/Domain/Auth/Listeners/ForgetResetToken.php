<?php

namespace App\Domain\Auth\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Cache;

class ForgetResetToken
{
    /**
     * Remove reset token storing in the cache.
     *
     * @param PasswordReset $event
     * @return void
     */
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;
        if (Cache::has($user->email)) {
            Cache::forget($user->email);
        }
    }
}
