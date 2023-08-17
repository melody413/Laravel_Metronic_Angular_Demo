<?php

use Illuminate\Database\Seeder;

class HospitalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Hospital::class, 10)->create()->each(function ($p) {
            factory(\App\Models\HospitalTrans::class, 1)->create([
                'hospital_id'=> $p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\HospitalTrans::class, 1)->create([
                'hospital_id'=> $p->id,
                'locale' => 'en'
            ]);
        });
    }
}
