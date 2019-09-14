<?php

namespace App\Providers;

use App\Entities\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 数据库
        Schema::defaultStringLength(191);
        // 菜单
        view()->composer('admin.layout', function ($view) {
            $menus = Permission::with([
                'childs' => function ($query) {
                    $query->with('icon');
                }
                , 'icon'])->where('parent_id', 0)->orderBy('sort', 'desc')->get();
            $view->with('menus', $menus);
            $view->with('admin', Auth::guard('admin')->user());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
