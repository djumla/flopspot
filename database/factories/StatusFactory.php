<?php

use Faker\Generator as Faker;

$factory->define(App\TwitterStatus::class, function (Faker $faker) {
    return [
        'status_id' => rand(5000, 300000),
        'status_author' => "@".$faker->firstName,
        'author_poked' => (bool)random_int(0, 1),
        'poked_date' => $faker->date('Y-m-d', 'now'),
    ];
});