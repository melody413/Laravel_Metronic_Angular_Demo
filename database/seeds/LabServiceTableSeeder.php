<?php

use Illuminate\Database\Seeder;

class LabServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\LabServiceTrans::truncate();
        \App\Models\LabService::truncate();

        factory(\App\Models\LabService::class, 100)->create()->each(function ($p) {
            factory(\App\Models\LabServiceTrans::class, 1)->create([
                'lab_service_id' => $p->id,
                'locale'  => 'ar'
            ]);
            factory(\App\Models\LabServiceTrans::class, 1)->create([
                'lab_service_id' => $p->id,
                'locale' => 'en'
            ]);
        });
    }
}
