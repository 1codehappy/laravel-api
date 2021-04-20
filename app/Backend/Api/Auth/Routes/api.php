<?php

use App\Backend\Api\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('auth')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login'])
            ->name('auth.login')
        ;
        Route::middleware('auth:api')
            ->group(function () {
                Route::get('me', [AuthController::class, 'me'])
                    ->name('auth.me')
                ;
                Route::post('logout', [AuthController::class, 'logout'])
                    ->name('auth.logout')
                ;
                Route::post('refresh', [AuthController::class, 'refresh'])
                    ->name('auth.refresh')
                ;
            })
        ;
    })
;
