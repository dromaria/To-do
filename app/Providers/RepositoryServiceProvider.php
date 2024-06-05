<?php

namespace App\Providers;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\TaskRepositories;
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
        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepositories::class
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
