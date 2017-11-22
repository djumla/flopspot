<?php

use Faker\Generator as Faker;

$factory->define(App\Rating::class, function (Faker $faker) {
    return [
        'entrance' => rand(1, 100),
        'exit' => rand(1, 100),
        'trainNumber' => rand(1, 700),
        'date' => $faker->date('Y-m-d', 'now'),
        'rating' => rand(1, 3),
    ];
});
