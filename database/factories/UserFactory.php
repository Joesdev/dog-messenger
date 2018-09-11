<?php

use Faker\Generator as Faker;
$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'rank'         => 0,
        'name'         => $faker->name(),
        'email'        => $faker->unique()->email(),
        'token'        => str_random(32),
        'selection_id' => factory(\App\Selection::class)->create()->id
    ];
});
