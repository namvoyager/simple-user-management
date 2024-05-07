# Simple User Management

[`PHP v8.2`](https://php.net)

[`Laravel v11.x`](https://github.com/laravel/laravel)

## Installation

Install using composer:

```bash
composer require namvoyager/simple-user-management
```

Publish and install initial resources

```bash
php artisan user-management:install
```

## Customize and override vendor logic

To customize the logic of the user management feature, you can open the `app/Http/Controllers/UserController` file.
Here the controller will use `UserRepository` to handle logic.

```php
namespace App\Http\Controllers;

use VoyagerInc\SimpleUserManagement\Contracts\UserRepository;

class UserController extends Controller
{
    public function __construct(
        protected UserRepository $users,
    ) {
    }
}
```

To be able to inherit or override `VoyagerInc\SimpleUserManagement\Repositories\UserRepository`,
you can define a new `App\Repositories\UserRepository` class and implement
`VoyagerInc\SimpleUserManagement\Contracts\UserRepository`.
Then go to `app\Providers\SimpleUserManagementServiceProvider` to declare,
now you can replace the `UserRepository` class of the vendor.

First, define a new `UserRepository` in path `app\Repositories`.

```php
namespace App\Repositories;

use VoyagerInc\SimpleUserManagement\Contracts\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    // Override all the methods of the interface here.
}
```

Then, go to `app\Providers\SimpleUserManagementServiceProvider.php`.

```php
use VoyagerInc\SimpleUserManagement\Contracts\UserRepository as UserRepositoryContract;
use App\Repositories\UserRepository;

public function register()
{
    $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
}
```

## Custom view

User management view files are located in the path `resources/views/users/`.
Corresponding to each screen there will be files: `index.blade.php`, `create.blade.php`, `show.blade.php`, `edit.blade.php`
