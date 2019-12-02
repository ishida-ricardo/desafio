<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    
    $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

    return [
        'id' => 0,
        'name' => $faker->name,
        'cpf' => $faker->cpf(false),
        'email' => $faker->unique()->safeEmail,
        'created_at' => "2018-08-27T02:11:43Z", //now(),
        'updated_at' => "2018-08-27T02:11:43Z", //now(),
    ];
});
