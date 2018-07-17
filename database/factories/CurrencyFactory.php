<?php

use Faker\Generator as Faker;
use App\Entity\Currency;

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'rate' => $faker->randomFloat(2, 0, 100000),
    ];
});