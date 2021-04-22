<?php

namespace App\Domain\User\Providers;

use App\Support\Contracts\Providers\DomainServiceProvider as ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Route files
     *
     * @var array
     */
    protected $routes = [
        'Backend/Api/Auth/Routes/api.php',
        'Backend/Api/User/Routes/api.php',
    ];
}
