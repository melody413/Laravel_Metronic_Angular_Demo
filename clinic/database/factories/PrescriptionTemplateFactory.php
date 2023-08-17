<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\PrescriptionTemplate::class, function (Faker $faker) {
    return [
        'name'  =>  'Template '.$faker->numberBetween(5,500),
        'status' => 1,
        'user_id'   => 1,
    ];
});
