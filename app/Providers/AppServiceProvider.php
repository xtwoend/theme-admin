<?php

namespace App\Providers;

use App\Entities\Setting;
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
        view()->composer('admin/*', function ($view){
            $view->with('menu', config('site.menu'));
            $view->with('submenu', config('site.submenu'));
        });

        if (Schema::hasTable('settings'))
        {
            $settings = Setting::first()->toArray();
            foreach ($settings as $key => $value) {
                config(["site.{$key}" => $value]);
            }
        }
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
