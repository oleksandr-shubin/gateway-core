<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'given_name' => $faker->firstName,
        'family_name' => $faker->lastName,
        'email' => $faker->unique()->email,
    ];
});

$factory->state(App\Customer::class, 'with_company', function (Faker $faker) {
    return [
        'company_id' => factory(Company::class)->create()->id,
    ];
});
