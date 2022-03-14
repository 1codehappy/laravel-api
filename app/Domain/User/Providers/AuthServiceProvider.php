<?php

namespace App\Domain\User\Providers;

use App\Domain\User\Models\User;
use App\Domain\User\Policies\UserPolicy;
use App\Support\Core\Contracts\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];
}
