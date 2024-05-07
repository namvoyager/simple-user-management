<?php

namespace VoyagerInc\SimpleUserManagement;

use Illuminate\Support\ServiceProvider;
use VoyagerInc\SimpleUserManagement\Console\Commands\InstallCommand;
use VoyagerInc\SimpleUserManagement\Contracts\UserRepository as UserRepositoryContract;
use VoyagerInc\SimpleUserManagement\Repositories\UserRepository;

class SimpleUserManagementServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/simple-user-management.php',
            'simple-user-management',
        );

        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
    }

    public function boot(): void
    {
        $this->configurePublishing();
    }

    /**
     * Configure the publishable resources offered by the package.
     */
    protected function configurePublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs/SimpleUserManagementServiceProvider.php' => $this->app->basePath('app/Providers/SimpleUserManagementServiceProvider.php'),
                __DIR__.'/../config/simple-user-management.php' => $this->app->basePath('config/simple-user-management.php'),
            ], 'simple-user-management-config');

            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
