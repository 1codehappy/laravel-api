<?php

use App\Backend\Api\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->group(function () {
        Route::prefix('roles')
            ->group(function () {
                Route::get('', [UserController::class, 'index'])
                    ->name('roles.index')
                ;
                Route::get('{role}', [UserController::class, 'show'])
                    ->name('roles.show')
                ;
                Route::post('', [UserController::class, 'store'])
                    ->name('roles.store')
                ;
                Route::put('{role}', [UserController::class, 'update'])
                    ->name('roles.update')
                ;
                Route::delete('{role}', [UserController::class, 'destroy'])
                    ->name('roles.destroy')
                ;
            })
        ;

        Route::prefix('permissions')
            ->group(function () {
                Route::get('', [UserController::class, 'index'])
                    ->name('permissions.index')
                ;
                Route::get('{permission}', [UserController::class, 'show'])
                    ->name('permissions.show')
                ;
                Route::post('', [UserController::class, 'store'])
                    ->name('permissions.store')
                ;
                Route::put('{permission}', [UserController::class, 'update'])
                    ->name('permissions.update')
                ;
                Route::delete('{permission}', [UserController::class, 'destroy'])
                    ->name('permissions.destroy')
                ;
            })
        ;
    })
;
