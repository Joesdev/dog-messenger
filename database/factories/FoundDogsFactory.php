<?php

use Faker\Generator as Faker;

$factory->define(\App\Found_Dog::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'new_breed_id' => $faker->numberBetween(41580000, 41609000),
        'miles' => $faker->numberBetween(25,150)
    ];
});
