<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\ChaletReservation::class, function (Faker $faker) {
    $startingDate = $faker->dateTimeBetween('this week', '+6 days');
    // Random datetime of the current week *after* `$startingDate`
    $endingDate   = $faker->dateTimeBetween(\Carbon\Carbon::parse($startingDate)->addDays(2), strtotime('+9 days'));
    return [
        //
        "reservation_id" =>function(){
            return factory(\App\Reservation::class)->create()->id;
        } ,
        "chalet_id"=>function(){
            return factory(\App\Chalet::class)->create()->id;
        },
        "start_date"=> $startingDate,
        "end_date" =>$endingDate
    ];
});
