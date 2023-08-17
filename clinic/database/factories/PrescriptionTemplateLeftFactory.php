<?php

use Faker\Generator as Faker;

$autoIncrement = autoIncrement();

$factory->define(\App\Model\PrescriptionTemplateLeft::class, function (Faker $faker)  use($autoIncrement) {
    $autoIncrement->next();
    return [
        'prescription_template_id'  =>  $autoIncrement->current(),
        'cc'    =>  $faker->text(),
        'oe'    =>  $faker->text(),
        'pd'    =>  $faker->text(),
        'dd'    =>  $faker->text(),
        'lab_workup'    =>  $faker->text(),
        'advice'    =>  $faker->text(),
    ];
});

function autoIncrement()
{
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}
