<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Common\Tree;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(public_path().'/themes/vender/filer', 'filer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tree',function(){
            return new Tree;
        });
        $this->app->bind(
            'App\Repositories\Eloquent\PageRepositoryInterface',
            \App\Repositories\Eloquent\PageRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\PageCategoryRepositoryInterface',
            \App\Repositories\Eloquent\PageCategoryRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\PageRecruitRepositoryInterface',
            \App\Repositories\Eloquent\PageRecruitRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\SettingRepositoryInterface',
            \App\Repositories\Eloquent\SettingRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\ShopRepositoryInterface',
            \App\Repositories\Eloquent\ShopRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\DistributorRepositoryInterface',
            \App\Repositories\Eloquent\DistributorRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\UserRepositoryInterface',
            \App\Repositories\Eloquent\UserRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\CityRepositoryInterface',
            \App\Repositories\Eloquent\CityRepository::class
        );
        $this->app->bind('city_repository', function ($app) {
            return new \App\Repositories\Eloquent\CityRepository($app);
        });
        $this->app->bind('filer', function ($app) {
            return new \App\Helpers\Filer\Filer();
        });
        $this->app->singleton('image', function ($app) {
            return new ImageManager($app['config']->get('image'));
        });
    }

    public function provides()
    {

    }
}
