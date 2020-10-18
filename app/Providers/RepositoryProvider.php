<?php

namespace App\Providers;

use App\Chalet;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\EloquentImpl\Chalet\ChaletRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\IRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(IRepository::class , BaseRepository::class);

        $this->app->bind(IChaletRepository::class , ChaletRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
