<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\City::class, 10)->create()->each(function ($p) {
            factory(\App\Models\CountryTrans::class, 1)->create([
                'city_id'=>$p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\CityTrans::class, 1)->create([
                'city_id'=>$p->id,
                'locale' => 'en'
            ]);
        });
    }
}
