<?php

namespace App\Domain\Permission\Providers;

use App\Domain\Permission\Models\Permission;
use App\Domain\Permission\Policies\PermissionPolicy;
use App\Support\Core\Contracts\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
    ];
}
