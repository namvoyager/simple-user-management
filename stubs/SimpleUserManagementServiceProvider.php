<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SimpleUserManagementServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->singleton(VoyagerInc\SimpleUserManagement\Contracts\UserRepository::class, function () {});
    }

    public function boot()
    {
        //
    }
}
