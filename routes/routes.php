<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->middleware(['web'])
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/', 'store')->name('users.store');
        Route::get('/{id}', 'show')->name('users.show');
        Route::get('/{id}/edit', 'edit')->name('users.edit');
        Route::put('/{id}', 'update')->name('users.update');
        Route::delete('/{id}', 'destroy')->name('users.destroy');
    });
