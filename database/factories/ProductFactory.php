<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'id' => 0,
        'sku' => $faker->randomNumber(),
        'name' => $faker->name,
        'price' => round($faker->randomFloat(2, 1, 200), 2),
        'created_at' => "2018-08-27T02:11:43Z", //now(),
        'updated_at' => "2018-08-27T02:11:43Z", //now(),
    ];
});
