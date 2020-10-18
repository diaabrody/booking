<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\App\ChaletType::class, function (Faker $faker) {
    return [
        //
        "name"=>$faker->name ,

    ];
});
