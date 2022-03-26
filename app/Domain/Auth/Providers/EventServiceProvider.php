<?php

namespace App\Domain\Auth\Providers;

use App\Domain\Auth\Listeners\ForgetResetToken;
use App\Support\Core\Contracts\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\PasswordReset;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PasswordReset::class => [
            ForgetResetToken::class,
        ],
    ];
}
