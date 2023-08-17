<?php

use Illuminate\Database\Seeder;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Faq::class, 5)->create()->each(function ($p) {
            factory(\App\Models\FaqTrans::class, 1)->create([
                'faq_id'=>$p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\FaqTrans::class, 1)->create([
                'faq_id'=>$p->id,
                'locale' => 'en'
            ]);
        });
    }
}
