<?php

use App\Backend\Api\Permission\Controllers\PermissionController;
use App\Backend\Api\Permission\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])
    ->group(function () {
        Route::prefix('roles')
            ->group(function () {
                Route::middleware('permission:roles.read')
                    ->group(function () {
                        Route::get('', [RoleController::class, 'index'])
                            ->name('roles.index')
                        ;
                        Route::get('{role}', [RoleController::class, 'show'])
                            ->name('roles.show')
                        ;
                    })
                ;
                Route::post('', [RoleController::class, 'store'])
                    ->name('roles.store')
                    ->middleware('permission:roles.create')
                ;
                Route::put('{role}', [RoleController::class, 'update'])
                    ->name('roles.update')
                    ->middleware('permission:roles.update')
                ;
                Route::delete('{role}', [RoleController::class, 'destroy'])
                    ->name('roles.destroy')
                    ->middleware('permission:roles.delete')
                ;
            })
        ;

        Route::prefix('permissions')
            ->group(function () {
                Route::get('', [PermissionController::class, 'index'])
                    ->name('permissions.index')
                    ->middleware('permission:permissions.read')
                ;
            })
        ;
    })
;
