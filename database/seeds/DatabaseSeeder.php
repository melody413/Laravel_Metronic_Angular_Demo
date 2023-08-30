<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             //AdminMenuTableSeeder::class

             //CountryTableSeeder::class,
             //CityTableSeeder::class,
             //AreaTableSeeder::class,
             //SpecialityTableSeeder::class,

             //InsuranceCompanyTableSeeder::class

             //PharmacyTableSeeder::class,
             //LabServiceTableSeeder::class,
             //LabTableSeeder::class
             //HospitalTableSeeder::class

             //UsersTableSeeder::class,
             //PagesTableSeeder::class,
             //FaqTableSeeder::class,


         ]);
    }
}
