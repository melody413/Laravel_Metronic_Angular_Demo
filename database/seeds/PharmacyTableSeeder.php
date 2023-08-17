<?php

use Illuminate\Database\Seeder;

class PharmacyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');

        \App\Models\PharmacyTrans::truncate();
        \App\Models\Pharmacy::truncate();

        factory(\App\Models\Pharmacy::class, 30)->create()->each(function ($p) {
            factory(\App\Models\PharmacyTrans::class, 1)->create([
                'pharmacy_id' => $p->id,
                'locale'  => 'ar'
            ]);
            factory(\App\Models\PharmacyTrans::class, 1)->create([
                'pharmacy_id' => $p->id,
                'locale' => 'en'
            ]);
        });
    }
}
