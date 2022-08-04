<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register Laravel Swagger
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

        // Register Laravel Telescope
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Prevent any model from using lazy loading and Prevent N+1 Issues in Laravel
        Model::preventLazyLoading(true);
    }
}
