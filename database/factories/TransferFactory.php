<?php

use App\Customer;
use Faker\Generator as Faker;

$factory->define(App\Transfer::class, function (Faker $faker) {
    return [
        'resource' => $faker->url,
        'amount' => $faker->numberbetween(100, 1000) * array_random([1, 10e3, 10e6, 10e9, 10e10]),
    ];
});

$factory->state(App\Customer::class, 'with_customer', function (Faker $faker) {
    $customer = factory(Customer::class)->state('with_company')->create();

    return [
        'customer_id' => $customer->id,
        'company_id' => $customer->company_id
    ];
});
