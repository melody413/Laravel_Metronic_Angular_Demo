<?php

use Faker\Generator as Faker;

$factory->define(App\Model\DrugStrength::class, function (Faker $faker) {
    return [
        'strength'  =>  $faker->unique()->numberBetween(1,1000) . 'mg',
        'user_id'   =>  1
    ];
});
