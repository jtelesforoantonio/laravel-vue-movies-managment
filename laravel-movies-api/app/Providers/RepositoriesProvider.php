<?php

namespace App\Providers;

use App\Contracts\Repositories\MovieRepositoryInterface;
use App\Repositories\MovieRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }
}
