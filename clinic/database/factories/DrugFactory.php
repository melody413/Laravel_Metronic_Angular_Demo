<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Drug::class, function (Faker $faker) {
    return [
        'name'  =>  $faker->unique()->userName,
        'generic_name'  =>  $faker->company,
        'user_id'   => 1
    ];
});
