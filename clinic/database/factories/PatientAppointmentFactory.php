<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\PatientAppointment::class, function (Faker $faker) {
    return [
        'patient_id'     =>  $faker->numberBetween(1,15),
        'appointment_id' =>  $faker->numberBetween(1,5),
        'date'           =>  $faker->dateTimeBetween('now','+1 years'),
        'time'           =>  $faker->time(),
        'note'           =>  $faker->text(),
        'status'         =>  0,
        'user_id'        =>  $faker->numberBetween(1,3)

    ];
});
