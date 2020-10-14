<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Chalet::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "long" =>$faker->longitude,
        "lat" => $faker->latitude,
        "location" => $faker->streetAddress,
        "city_id" => function(){
            return factory('App\City')->create()->id;
        },
        "discount" => $faker->randomNumber(2) ,
        "markup" =>$faker->randomNumber(2),
        "isActive" => $faker->boolean,
        "rooms_numbers" => $faker->randomNumber(1),
        "beds_numbers" => $faker->randomNumber(1),
        "floor_numbers" => $faker->randomNumber(1),
        "capacity" => $faker->randomNumber(1),
        "description" => $faker->text,


    ];
});
