<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\PrescriptionTemplateDrug::class, function (Faker $faker) {
    return [
        'prescription_template_id'  =>  $faker->numberBetween(1,50),
        'drug_id'                   =>  $faker->numberBetween(1,476),
        'type'                      =>  'Tab',
        'dose'                      =>  '1+0+1',
        'duration'                  =>  $faker->numberBetween(1,10) . "Days",
        'strength'                  =>  $faker->numberBetween(10,1000) . "mg",
        'advice'                    =>  $faker->text(40)
    ];
});
