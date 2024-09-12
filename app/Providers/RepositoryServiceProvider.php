<?php

namespace App\Providers;

use App\Repositories\EmailRepositories;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\TaskRepositories;
use App\Repositories\TodoRepositories;
use App\Repositories\UserRepositories;
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
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepositories::class
        );
        $this->app->bind(
            EmailRepositoryInterface::class,
            EmailRepositories::class
        );
    }

    public function boot(): void
    {
        //
    }
}
