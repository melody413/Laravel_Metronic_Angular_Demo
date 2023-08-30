<?php

use Illuminate\Database\Seeder;

class InsuranceCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\InsuranceCompany::truncate();
        \App\Models\InsuranceCompanyTrans::truncate();

        factory(\App\Models\InsuranceCompany::class, 50)->create()->each(function ($p) {
            factory(\App\Models\InsuranceCompanyTrans::class, 1)->create([
                'insurance_company_id'=>$p->id,
                'locale' => 'ar'
            ]);
            factory(\App\Models\InsuranceCompanyTrans::class, 1)->create([
                'insurance_company_id'=>$p->id,
                'locale' => 'en'
            ]);
        });
    }
}
