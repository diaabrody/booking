<?php

namespace App\Providers;

use App\Chalet;
use App\Repositories\AlgoliaImpl\City\AlgoliaCitytRepository;
use App\Repositories\AlgoliaImpl\Resort\AlgoliaResorttRepository;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\EloquentImpl\Chalet\ChaletRepository;
use App\Repositories\EloquentImpl\ChaletRating\ChaletRatingRepository;
use App\Repositories\EloquentImpl\UserView\UserViewRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\City\ICityAlgoliaRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\Resort\IResortAlgoliaRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\ChaletRating\IChaletRatingRepository;
use App\Repositories\Interfaces\UserView\IUserViewRepository;
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

        $this->app->bind(IUserViewRepository::class , UserViewRepository::class);

        $this->app->bind(IChaletRatingRepository::class , ChaletRatingRepository::class);

        $this->app->bind(ICityAlgoliaRepository::class , AlgoliaCitytRepository::class);
        $this->app->bind(IResortAlgoliaRepository::class , AlgoliaResorttRepository::class);
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
