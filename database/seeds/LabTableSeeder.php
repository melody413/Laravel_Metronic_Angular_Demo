<?php

use Illuminate\Database\Seeder;

class LabTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\Lab::truncate();
        \App\Models\LabTrans::truncate();

        factory(\App\Models\Lab::class, 40)->create()->each(function ($p) {
            factory(\App\Models\LabTrans::class, 1)->create([
                'lab_id' => $p->id,
                'locale'  => 'ar'
            ]);
            factory(\App\Models\LabTrans::class, 1)->create([
                'lab_id' => $p->id,
                'locale' => 'en'
            ]);
            $lab_services = \App\Models\LabService::inRandomOrder()->limit(10)->get()->pluck('id');
            $p->LabServices()->sync($lab_services);
        });
    }
}
