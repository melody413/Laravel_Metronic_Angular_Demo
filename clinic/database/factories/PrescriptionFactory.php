<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Prescription::class, function (Faker $faker) {
    return [
        'patient_id'    =>  $faker->numberBetween(1,1501),
        'prescription_template_id'  =>  $faker->numberBetween(1,50),
        'prescription_date'         =>  $faker->date(),
        'next_visit'                =>  $faker->date(),
        'user_id'                   =>  1
    ];
});
