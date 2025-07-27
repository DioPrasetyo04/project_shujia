<?php

namespace App\Providers;

use App\Services\CategoryServices;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\HomeServiceRepository;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\HomeServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryInterface::class, CategoryRepository::class);
        $this->app->singleton(HomeServiceInterface::class, HomeServiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
