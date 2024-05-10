<?php

namespace App\Providers;

use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\TodoRepositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TodoRepositoryInterface::class,
            TodoRepositories::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
