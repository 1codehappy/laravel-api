<?php

namespace App\Domain\Permission\Providers;

use App\Support\Core\Contracts\Providers\DomainServiceProvider as ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Route files
     *
     * @var array
     */
    protected $routes = [
        'Backend/Api/Permission/Routes/api.php',
    ];
}
