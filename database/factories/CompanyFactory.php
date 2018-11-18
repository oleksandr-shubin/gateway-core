<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'quota' => $faker->numberbetween(100, 1000) * array_random([1, 10e3, 10e6, 10e9, 10e10]),
    ];
});
