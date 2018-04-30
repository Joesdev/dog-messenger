<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'rank'         => 0,
        'name'         => $faker->name(),
        'email'        => $faker->unique()->email(),
        'selection_id' => $faker->numberBetween(1,100)
    ];
});
