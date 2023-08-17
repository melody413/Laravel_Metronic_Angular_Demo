<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\AppointmentDateTime::class, function (Faker $faker) {
    return [
        'appointment_id'    =>  $faker->numberBetween(1,5),
        'days'              =>  $faker->dayOfWeek,
        'start_time'        =>  $faker->time(),
        'end_time'          =>  $faker->time(),
        'user_id'           =>  1
    ];
});
