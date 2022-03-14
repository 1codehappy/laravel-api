<?php

namespace App\Backend\Api\HealthCheck\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelServiceProvider;

class RouteServiceProvider extends LaravelServiceProvider
{
    /**
     * Map api route
     *
     * @return void
     */
    public function map(): void
    {
        include app_path('Backend/Api/HealthCheck/Routes/api.php');
    }
}
