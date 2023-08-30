<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Patient::class, function (Faker $faker) {
    static $avater;
    return [
        'name'          =>  $faker->name,
        'gender'        =>  1,
        'date_of_birth' =>  $faker->date(),
        'image'         =>  $faker->image('uploads/patient',400,400,'people',true),
        'email'         =>  $faker->email,
        'address'       =>  $faker->address,
        'phone'         =>  $faker->phoneNumber,
        'status'        =>  1,
        'user_id'       =>  1
    ];
});
