<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\interfaces\AdminRepository::class, \App\Repositories\repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\interfaces\RoleRepository::class, \App\Repositories\repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\interfaces\PermissionRepository::class, \App\Repositories\repositories\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\interfaces\ConfigRepository::class, \App\Repositories\repositories\ConfigRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\interfaces\AdminLogRepository::class, \App\Repositories\repositories\AdminLogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\interfaces\OperationLogRepository::class, \App\Repositories\repositories\OperationLogRepositoryEloquent::class);


    }
}
