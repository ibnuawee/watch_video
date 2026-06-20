<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\CustomerRepositoryInterface::class,
            \App\Repositories\Eloquent\CustomerRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\VideoCategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\VideoCategoryRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\VideoRepositoryInterface::class,
            \App\Repositories\Eloquent\VideoRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\VideoAccessRequestRepositoryInterface::class,
            \App\Repositories\Eloquent\VideoAccessRequestRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
