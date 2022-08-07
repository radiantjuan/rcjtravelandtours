<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Booking::class, function (Faker $faker) {
    $from = \Carbon\Carbon::instance($faker->dateTimeBetween('-1 months', '+1 months'));
    $to = (clone $from)->addDay(random_int(0, 14));
    return [
        'from' => $from,
        'to' => $to
    ];
});
