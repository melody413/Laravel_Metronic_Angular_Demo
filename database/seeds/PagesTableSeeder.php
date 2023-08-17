<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Page::class, 100)->create()->each(function ($p) {
            factory(\App\Models\PageTrans::class, 1)->create([
                'page_id'=>$p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\PageTrans::class, 1)->create([
                'page_id'=>$p->id,
                'locale' => 'en'
            ]);
        });
    }
}
