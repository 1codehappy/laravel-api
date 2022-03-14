<?php

use App\Backend\Api\HealthCheck\Controllers\PingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])
    ->group(function () {
        Route::get('ping', PingController::class)
            ->name('ping.pong');
    });
