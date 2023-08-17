<?php

use Faker\Generator as Faker;
$_autoIncrement = _autoIncrement();
$factory->define(\App\Model\PrescriptionLeft::class, function (Faker $faker) use ($_autoIncrement) {
    $_autoIncrement->next();
    return [
        'prescription_id'   =>  $_autoIncrement->current(),
        'cc'    =>  $faker->text('80'),
        'oe'    =>  $faker->text('80'),
        'pd'    =>  $faker->text('80'),
        'dd'    =>  $faker->text('80'),
        'lab_workup'    =>  $faker->text('80'),
        'advice'    =>  $faker->text('80'),
    ];
});
function _autoIncrement()
{
    for ($i = 0; $i < 2000; $i++) {
        yield $i;
    }
}
