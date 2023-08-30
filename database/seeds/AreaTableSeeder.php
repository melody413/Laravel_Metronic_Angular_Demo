<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Area::class, 10)->create()->each(function ($p) {
            factory(\App\Models\AreaTrans::class, 1)->create([
                'area_id'=>$p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\AreaTrans::class, 1)->create([
                'area_id'=>$p->id,
                'locale' => 'en'
            ]);
        });
    }
}
