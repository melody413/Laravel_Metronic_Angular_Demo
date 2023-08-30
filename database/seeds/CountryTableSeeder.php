<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Country::class, 10)->create()->each(function ($p) {
            factory(\App\Models\CountryTrans::class, 1)->create([
                'country_id' => $p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\CountryTrans::class, 1)->create([
                'country_id' => $p->id,
                'locale' => 'en'
            ]);
        });
    }
}
