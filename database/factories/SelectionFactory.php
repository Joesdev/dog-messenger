<?php

use Faker\Generator as Faker;
$factory->define(\App\Selection::class, function (Faker $faker) {
    return [
        'breed_id'         => $faker->numberBetween(1,249),
        'zip'              => $faker->numberBetween(90001,96162),
        'highest_breed_id' => $faker->numberBetween(41509748, 41540000),
        'max_miles'        => $faker->randomElement(['50', '75', '100']),
        'match'            => 0,
    ];
});
