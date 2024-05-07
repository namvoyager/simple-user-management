<?php

namespace VoyagerInc\SimpleUserManagement\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\SplFileInfo;
use VoyagerInc\SimpleUserManagement\SimpleUserManagementServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-management:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the User Management resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', [
            '--provider' => SimpleUserManagementServiceProvider::class,
        ]);

        $this->registerSupport();
        $this->registerRoutes();
        $this->makeViewFile();
        $this->registerSimpleUserManagementServiceProvider();

        $this->components->info('SimpleUserManagement scaffolding was installed successfully.');
    }

    /**
     * Register the Fortify service provider in the application configuration file.
     */
    protected function registerSimpleUserManagementServiceProvider(): void
    {
        if (! method_exists(ServiceProvider::class, 'addProviderToBootstrapFile')) {
            return;
        }

        ServiceProvider::addProviderToBootstrapFile(\App\Providers\SimpleUserManagementServiceProvider::class);
    }

    protected function registerSupport(): void
    {
        $filesystem = new Filesystem();

        $filesystem->copy(__DIR__.'/../../../stubs/UserController.php', app_path('Http/Controllers/UserController.php'));

        if (! is_dir($directory = app_path('Http/Requests'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem->copy(
            __DIR__.'/../../../stubs/CreateUserRequest.php',
            app_path('Http/Requests/CreateUserRequest.php'),
        );
        $filesystem->copy(
            __DIR__.'/../../../stubs/UpdateUserRequest.php',
            app_path('Http/Requests/UpdateUserRequest.php'),
        );
    }

    protected function registerRoutes(): void
    {
        $filesystem = new Filesystem();
        $filesystem->copy(__DIR__.'/../../../routes/routes.php', $this->laravel->basePath('routes/user-management.php'));

        $file = $this->laravel->basePath('routes/web.php');
        $current = file_get_contents($file);
        $current .= "\nrequire __DIR__.'/user-management.php';\n";
        file_put_contents($file, $current);
    }

    protected function makeViewFile()
    {
        if (! is_dir($directory = $this->laravel->basePath('resources/views/users'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem();

        collect($filesystem->allFiles(__DIR__.'/../../../stubs/views/users'))
            ->each(function (SplFileInfo $file) use ($filesystem, $directory) {
                $pathFile = $directory.'/'.$file->getFilename();

                if (! file_exists($pathFile)) {
                    $filesystem->copy(
                        $file->getPathname(),
                        $pathFile,
                    );
                }
            });
    }
}
