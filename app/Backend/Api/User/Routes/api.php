<?php

use App\Backend\Api\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])
    ->prefix('users')
    ->group(function () {
        Route::middleware('permission:users.read')
            ->group(function () {
                Route::get('', [UserController::class, 'index'])
                    ->name('users.index')
                ;
                Route::get('{user}', [UserController::class, 'show'])
                    ->name('users.show')
                ;
            })
        ;
        Route::post('', [UserController::class, 'store'])
            ->name('users.store')
            ->middleware('permission:users.create')
        ;
        Route::put('{user}', [UserController::class, 'update'])
            ->name('users.update')
            ->middleware('permission:users.update')
        ;
        Route::delete('{user}', [UserController::class, 'destroy'])
            ->name('users.destroy')
            ->middleware('permission:users.delete')
        ;
    })
;
