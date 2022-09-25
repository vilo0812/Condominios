<?php

namespace App\Providers;

use App\Repository\BaseRepository;
use App\Repository\BaseRepositoryInterface;

use App\Repository\User\UserRepository;
use App\Repository\User\UserRepositoryInterface;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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

        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }
}
