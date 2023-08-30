<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\PrescriptionDrug::class, function (Faker $faker) {
    return [
        'prescription_id'   =>  $faker->numberBetween(1,1500),
        'drug_id'           =>  $faker->numberBetween(1,476),
        'type'              =>  $faker->randomElement(array('Tab','Cap','Inj','Cream')),
        'dose'              =>  $faker->randomElement(array('1+1+1','1+0+1','1+0+0','0+1+0','0+0+1','Use ever 6 Hour')),
        'duration'          =>  $faker->randomElement(array('7 Days','2 Days','90 Days','1 Year','Till next visit')),
        'strength'          =>  $faker->numberBetween(1,700).$faker->randomElement(array('mg','ml','')),
        'advice'            =>  $faker->randomElement(array('Shake before use','Before meal','After meal',''))
    ];
});
