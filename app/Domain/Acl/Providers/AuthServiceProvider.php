<?php

namespace App\Domain\Acl\Providers;

use App\Domain\Acl\Models\Permission;
use App\Domain\Acl\Policies\PermissionPolicy;
use App\Support\Core\Contracts\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
    ];
}
