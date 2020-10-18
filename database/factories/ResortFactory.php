<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Resort::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->streetName ,
        'city_id'=>function(){return factory(\App\City::class)->create()->id;}
    ];
});
