<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bookable;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$suffix = [
    'Villa',
    'Resort',
    'Suite',
    'Hotel',
    'House',
    'Pool',
    'Beach',
    'Staycation'
];

$factory->define(Bookable::class, function (Faker $faker) use($suffix){
    return [
        'title' => $faker->city. ' ' . Arr::random($suffix),
        'description' => $faker->text(),
        'price' => random_int(15, 600)
    ];
});
