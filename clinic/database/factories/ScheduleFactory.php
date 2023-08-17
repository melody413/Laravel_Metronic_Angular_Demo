<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Appointment::class, function (Faker $faker) {
    return [
        'name'                  =>  $faker->company,
        'address'               =>  $faker->address,
        'phone'                 =>  $faker->phoneNumber,
        'email'                 =>  $faker->email,
        'contact_person_name'   =>  $faker->name,
        'user_id'               =>  1
    ];
});
