<?php

namespace App\Providers;

use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;

/**
 * Class BaseRepositoryProvider
 *
 * @package App\Providers
 */
class BaseRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        /**
         * Root Repository
         */
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }
}
