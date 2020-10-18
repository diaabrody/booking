<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\App\Chalet::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "long" =>$faker->longitude,
        "lat" => $faker->latitude,
        "location" => $faker->streetAddress,
        "discount" => $faker->randomNumber(2) ,
        "markup" =>$faker->randomNumber(2),
        "isActive" => $faker->boolean,
        "rooms_numbers" => $faker->randomNumber(1),
        "beds_numbers" => $faker->randomNumber(1),
        "floor_numbers" => $faker->randomNumber(1),
        "capacity" => $faker->randomNumber(1),
        "price" =>100000.443,
        "description" => $faker->text,
        "resort_id" =>  function($faker){
           return factory(\App\Resort::class)->create()->id;
        } ,
        "type_id"=> function($faker) {
            return factory(\App\ChaletType::class)->create()->id;
        } ,
        "chalet_view_id"=> function($faker) {
            return factory(\App\ChaletView::class)->create()->id;
        },
        "city_id"=>function($faker) {
            return factory(\App\City::class)->create()->id;
        }
    ];
});
