<?php

namespace App\Providers;

use App\Chalet;
use App\ChaletReservation;
use App\City;
use App\Repositories\AlgoliaImpl\City\AlgoliaCitytRepository;
use App\Repositories\AlgoliaImpl\Resort\AlgoliaResorttRepository;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\EloquentImpl\Chalet\ChaletRepository;
use App\Repositories\EloquentImpl\ChaletRating\ChaletRatingRepository;
use App\Repositories\EloquentImpl\ChaletReservation\ChaletReservationRepository;
use App\Repositories\EloquentImpl\City\CityRepository;
use App\Repositories\EloquentImpl\UserView\UserViewRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\City\ICityAlgoliaRepository;
use App\Repositories\Interfaces\AlgoliaInterfaces\Resort\IResortAlgoliaRepository;
use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\ChaletRating\IChaletRatingRepository;
use App\Repositories\Interfaces\ChaletReservation\IChaletReservationRepository;
use App\Repositories\Interfaces\City\ICityRepository;
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

    protected $map = [
        IRepository::class => BaseRepository::class,
        IChaletRepository::class => ChaletRepository::class,
        IUserViewRepository::class => UserViewRepository::class,
        IChaletRatingRepository::class => ChaletRatingRepository::class,
        ICityAlgoliaRepository::class => AlgoliaCitytRepository::class,
        IResortAlgoliaRepository::class => AlgoliaResorttRepository::class,
        ICityRepository::class => CityRepository::class ,
        IChaletReservationRepository::class => ChaletReservationRepository::class
    ];

    public function register()
    {
        foreach ($this->map as $abstract => $class) {
            $this->app->bind($abstract, $class);
        }

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
