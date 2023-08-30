<?php

use Illuminate\Database\Seeder;

class SpecialityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Specialty::class, 10)->create()->each(function ($p) {
            factory(\App\Models\SpecialtyTrans::class, 1)->create([
                'specialty_id'=>$p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\SpecialtyTrans::class, 1)->create([
                'specialty_id'=>$p->id,
                'locale' => 'en'
            ]);
        });
    }
}
