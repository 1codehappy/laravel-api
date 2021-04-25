<?php

use App\Backend\Api\Auth\Controllers\ChangePasswordController;
use App\Backend\Api\Auth\Controllers\LoginController;
use App\Backend\Api\Auth\Controllers\LogoutController;
use App\Backend\Api\Auth\Controllers\ProfileController;
use App\Backend\Api\Auth\Controllers\RefreshTokenController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('auth')
    ->group(function () {
        Route::post('login', LoginController::class)
            ->name('auth.login')
        ;
        Route::middleware('auth:api')
            ->group(function () {
                Route::get('me', [ProfileController::class, 'index'])
                    ->name('auth.me')
                ;
                Route::put('me', [ProfileController::class, 'update'])
                    ->name('auth.me')
                ;
                Route::put('me/password', ChangePasswordController::class)
                    ->name('auth.password')
                ;
                Route::post('logout', LogoutController::class)
                    ->name('auth.logout')
                ;
                Route::post('refresh', RefreshTokenController::class)
                    ->name('auth.refresh')
                ;
            })
        ;
    })
;
