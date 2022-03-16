<?php

namespace App\Domain\Acl\Providers;

use App\Support\Core\Contracts\Providers\DomainServiceProvider as ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Route files
     *
     * @var array
     */
    protected $routes = [
        'Backend/Api/Acl/Routes/api.php',
    ];
}
